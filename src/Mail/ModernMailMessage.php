<?php
namespace ModernMail\Mail;

use Illuminate\Notifications\Messages\MailMessage as LegacyMailMessage;
use ModernMail\Mail\Traits\Taggable;
use ModernMail\Mail\Traits\Trackable;
use ModernMail\Mail\Traits\MJMLViews;

class ModernMailMessage extends LegacyMailMessage
{
    public function previewText($text) {
        $this->viewData['previewText'] = $text;
    }

    use Taggable,
        Trackable,
        MJMLViews;

}
