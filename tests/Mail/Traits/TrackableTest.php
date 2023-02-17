<?php

namespace Tests\Mail\Traits;

use Illuminate\Support\Facades\Notification;
use Tests\BaseTestCase;
use Tests\fixtures\Notifications\TrackableNotification;

class TrackableTest extends BaseTestCase {

    /**
     * @test
     */
    public function array_tracking_enabled() {

        $this->interceptMail();

        $trackClicksHeader = config('modern-mailer.services.default.headers.track-clicks');
        $trackOpensHeader = config('modern-mailer.services.default.headers.track-opens');
        $val = config('modern-mailer.services.default.header_on_value');

        Notification::route('mail', 'test@test.com')
            ->notifyNow(new TrackableNotification(true));

        $interceptedMail = $this->interceptedMail()->first();
        $this->assertMailSentTo('test@test.com', $interceptedMail);
        $this->assertMailHasHeader($trackClicksHeader, $interceptedMail);
        $this->assertMailHeaderIs($trackClicksHeader, $val, $interceptedMail);

        $this->assertMailHasHeader($trackOpensHeader, $interceptedMail);
        $this->assertMailHeaderIs($trackOpensHeader, $val, $interceptedMail);
    }

    /**
     * @test
     */
    public function array_tracking_disable() {

        $this->interceptMail();

        $trackClicksHeader = config('modern-mailer.services.default.headers.track-clicks');
        $trackOpensHeader = config('modern-mailer.services.default.headers.track-opens');
        $val = config('modern-mailer.services.default.header_off_value');

        Notification::route('mail', 'test@test.com')
            ->notifyNow(new TrackableNotification(false));

        $interceptedMail = $this->interceptedMail()->first();
        $this->assertMailSentTo('test@test.com', $interceptedMail);
        $this->assertMailHasHeader($trackClicksHeader, $interceptedMail);
        $this->assertMailHeaderIs($trackClicksHeader, $val, $interceptedMail);

        $this->assertMailHasHeader($trackOpensHeader, $interceptedMail);
        $this->assertMailHeaderIs($trackOpensHeader, $val, $interceptedMail);
    }

}
