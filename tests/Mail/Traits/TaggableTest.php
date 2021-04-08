<?php

namespace Tests\Mail\Traits;

use Illuminate\Support\Facades\Notification;
use Tests\BaseTestCase;
use Tests\fixtures\Notifications\TaggableNotification;

class TaggableTest extends BaseTestCase {

    /**
     * @test
     */
    public function tag_headers_set() {

        $this->interceptMail();

        $header = config('modern-mailer.services.array.headers.tag');

        Notification::route('mail', 'test@test.com')
            ->notifyNow(new TaggableNotification('test-tag'));

        $interceptedMail = $this->interceptedMail()->first();
        $this->assertMailSentTo('test@test.com', $interceptedMail);
        $this->assertMailHasHeader($header, $interceptedMail);
        $this->assertMailHeaderIs($header, 'test-tag', $interceptedMail);
    }

}
