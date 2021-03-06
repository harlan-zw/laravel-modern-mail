<?php
namespace Tests\fixtures\Notifications;

use ModernMail\Mail\ModernMailMessage;
use ModernMail\Notifications\ModernMailNotification;

class MJMLNotification extends ModernMailNotification {

    public static $tag = 'test-tag';

    public $name = 'name test';
    public $title = 'title test';

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new ModernMailMessage)
            ->mjml('basic', [
                'siteUrl' => 'test',
            ]);
    }

}
