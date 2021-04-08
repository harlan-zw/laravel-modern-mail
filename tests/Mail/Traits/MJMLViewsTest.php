<?php
namespace Tests\Mail\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Swift_Message;
use Tests\BaseTestCase;
use Tests\fixtures\Notifications\MJMLNotification;
use Tests\fixtures\Notifications\TrackableNotification;

class MJMLViewsTest extends BaseTestCase {

    /**
     * @test
     */
    public function mjml_send_works() {
        $this->interceptMail();

        Notification::route('mail', 'test@test.com')
            ->notifyNow(new MJMLNotification);

        /** @var Swift_Message $interceptedMail */
        $interceptedMail = $this->interceptedMail()->first();
        $this->assertMailSentTo('test@test.com', $interceptedMail);

        // need to change dynamic data to be static so the snapshot matches
        $interceptedMail->setId('1230173678.4952f5eeb1432@swift.generated');
        $interceptedMail->setDate(Carbon::create(2020, 10, 10));
        $interceptedMail->setBoundary('_=_swift_1617803604_13f6c75c299adff03ee1bdb43a3f577d_=_');

        // make sure we don't have any mj tags left
        self::assertStringNotContainsString('<mj', $interceptedMail->getBody());
        $this->assertMatchesTextSnapshot($interceptedMail->toString());
    }
}
