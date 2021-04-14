<?php
namespace ModernMail\Notifications\Channels;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Notification;
use ModernMail\Mail\ModernMailMessage;
use ModernMail\Process\MJML;
use ReflectionClass;
use ReflectionProperty;

class ModernMailChannel extends MailChannel {

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var ModernMailMessage $message */
        $message = $notification->toMail($notifiable);

        // make the viewData a bit smart
        $message->viewData = array_merge(
            collect(
            // add in public properties from the email
                (new ReflectionClass($notification))
                    ->getProperties(ReflectionProperty::IS_PUBLIC)
            )
                // don't inherit properties from base classes
                ->filter(function(ReflectionProperty $property) use ($notification) {
                    return $property->class === get_class($notification);
                })
                // map the properties to array format
                ->mapWithKeys(function(ReflectionProperty $property) use ($notification) {
                    return [$property->getName() => $property->getValue($notification)];
                })
                ->toArray(),
            // add the notifiable
            [
                'notifiable' => $notifiable
            ],
            // merge in the original view data after
            $message->viewData
        );

        if (! $notifiable->routeNotificationFor('mail', $notification) &&
            ! $message instanceof Mailable) {
            return;
        }

        if ($message instanceof Mailable) {
            return $message->send($this->mailer);
        }

        $this->mailer->mailer($message->mailer ?? null)->send(
            $this->buildView($message),
            array_merge($message->data(), $this->additionalMessageData($notification)),
            $this->messageBuilder($notifiable, $notification, $message)
        );
    }

    public function buildView($message) {
        if (!empty($message->mjml)) {
            $mjml = new MJML(view($message->mjml, $message->viewData));
            return $mjml->render();
        }
        return parent::buildView($message);
    }

}
