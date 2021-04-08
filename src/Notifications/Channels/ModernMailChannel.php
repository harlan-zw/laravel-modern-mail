<?php
namespace ModernMail\Notifications\Channels;

use Illuminate\Notifications\Channels\MailChannel;
use ModernMail\Process\MJML;

class ModernMailChannel extends MailChannel {

    public function buildView($message) {
        if (!empty($message->mjml)) {
            $mjml = new MJML(view($message->mjml, $message->viewData));
            return $mjml->render();
        }
        return parent::buildView($message);
    }

}
