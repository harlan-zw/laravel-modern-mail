<?php

namespace ModernMail\Mail\Traits;

use Illuminate\Support\Str;
use ModernMail\Mail\ModernMailMessage;

trait Trackable {

    public function setTrackingHeaders($enabled) {
       return $enabled ? $this->enableTracking() : $this->disableTracking();
    }

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

    protected function setTrackableHeader($scope, $enable) {
        $this->callbacks['tracking.' . $scope] = function (\Swift_Message $message) use ($scope, $enable) {
            $mailDriver = config('mail.driver');

            $valueKey = $enable ? 'header_on_value' : 'header_off_value';
            $header = config("modern-mailer.services.$mailDriver.headers.track-$scope");
            $value = config("modern-mailer.services.$mailDriver.$valueKey");
            $message
                ->getHeaders()
                ->addTextHeader($header, $value);
        };
        return $this;
    }

    public function enableTrackingClicks() {
        return $this->setTrackableHeader('clicks', true);
    }

    public function disableTrackingClicks() {
        return $this->setTrackableHeader('clicks', false);
    }

    public function enableTrackingOpens() {
        return $this->setTrackableHeader('opens', true);
    }

    public function disableTrackingOpens() {
        return $this->setTrackableHeader('opens', false);
    }

}
