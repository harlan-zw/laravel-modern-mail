<?php
namespace Tests\fixtures\Notifications;

use ModernMail\Mail\ModernMailMessage;
use ModernMail\Notifications\ModernMailNotification;

class InvalidMjmlNotification extends ModernMailNotification {

    public static $tag = 'test-tag';

    public $title = 'title test';

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new ModernMailMessage)
            ->mjml('invalid-mjml');
    }

}
