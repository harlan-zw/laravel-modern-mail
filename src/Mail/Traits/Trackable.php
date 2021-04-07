<?php

namespace ModernMail\Mail\Traits;

use Illuminate\Support\Str;
use ModernMail\Mail\ModernMailMessage;

trait Trackable {

    public function enableTracking() {
        $this->enableTrackingClicks();
        $this->enableTrackingOpens();
        return $this;
    }

    public function disableTracking() {
        $this->disableTrackingClicks();
        $this->disableTrackingOpens();
        return $this;
    }

    public function enableTrackingClicks() {
        $this->callbacks['tracking.clicks'] = function (\Swift_Message $message) {
            switch(config('mail.driver')) {
                case 'mailgun':
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-Mailgun-Track-Clicks', 'yes');
                    break;
                case 'postmark':
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-PM-TrackLinks', 'true');
                    break;
            }
        };
        return $this;
    }

    public function disableTrackingClicks() {
        $this->callbacks['tracking.clicks'] = function (\Swift_Message $message) {
            switch(config('mail.driver')) {
                case 'mailgun':
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-Mailgun-Track-Clicks', 'no');
                    break;
                case 'postmark':
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-PM-TrackLinks', 'false');
                    break;
            }
        };
        return $this;
    }

    public function enableTrackingOpens() {
        $this->callbacks['tracking.opens'] = function (\Swift_Message $message) {
            switch(config('mail.driver')) {
                case 'mailgun':
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-Mailgun-Track-Opens', 'yes');
                    break;
                case 'postmark':
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-PM-TrackOpens', 'true');
                    break;
            }
        };
        return $this;
    }

    public function disableTrackingOpens() {
        $this->callbacks['tracking.opens'] = function (\Swift_Message $message) {
            switch(config('mail.driver')) {
                case 'mailgun':
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-Mailgun-Track-Opens', 'no');
                    break;
                case 'postmark':
                    $message
                        ->getHeaders()
                        ->addTextHeader('X-PM-TrackOpens', 'false');
                    break;
            }
        };
        return $this;
    }

}
