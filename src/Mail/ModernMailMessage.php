<?php
namespace ModernMail\Mail;

use Illuminate\Notifications\Messages\MailMessage as LegacyMailMessage;
use ModernMail\Mail\Traits\Taggable;
use ModernMail\Mail\Traits\Trackable;
use ModernMail\Mail\Traits\MJMLViews;

class ModernMailMessage extends LegacyMailMessage
{
    use Taggable,
        Trackable,
        MJMLViews;

}
