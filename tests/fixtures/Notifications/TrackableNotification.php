<?php
namespace Tests\fixtures\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use ModernMail\Mail\ModernMailMessage;

class TrackableNotification extends Notification implements ShouldQueue {

    use Queueable;

    private $tracking;
    /**
     * TrackableNotification constructor.
     */
    public function __construct($tracking) {
        $this->tracking = $tracking;
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new ModernMailMessage)
            ->view(['html' => 'basic'], [
                'name' => 'mjml test',
                'title' => 'test',
                'siteUrl' => 'test',
            ])
            ->setTrackingHeaders($this->tracking);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
}
