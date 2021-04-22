<?php
namespace ModernMail\Notifications\Channels;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Notification;
use ModernMail\Mail\ModernMailMessage;

class ModernMailChannel extends MailChannel {

    public function preview($notifiable, Notification $notification) {
        /** @var ModernMailMessage $message */
        $message = $notification->toMail($notifiable);

        if ($message instanceof ModernMailMessage) {
            $message
                ->addTagsFromNotification($notification)
                ->inheritPropertiesFromNotification($notification)
                ->notifiable($notifiable);
        }

        return $this->mailer->mailer($message->mailer ?? null)->render(
            $this->buildView($message),
            array_merge($message->data(), $this->additionalMessageData($notification)),
        );
    }

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

        if ($message instanceof ModernMailMessage) {
            $message
                ->addTagsFromNotification($notification)
                ->inheritPropertiesFromNotification($notification)
                ->notifiable($notifiable);
        }

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

        if (($message instanceof ModernMailMessage) && !empty($message->mjml)) {
            return $message->render();
        }

        return parent::buildView($message);
    }

}
