<?php
namespace Tests\fixtures\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use ModernMail\Mail\ModernMailMessage;

class TaggableNotification extends Notification implements ShouldQueue {

    use Queueable;

    public $tag;

    /**
     * TaggableNotification constructor.
     */
    public function __construct($tag) {
        $this->tag = $tag;
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
            ->view('basic', [
                'name' => 'mjml test',
                'title' => 'test',
                'siteUrl' => 'test',
            ])
            ->namespacedTag($this->tag);
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
