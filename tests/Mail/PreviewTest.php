<?php


namespace Mail;

use Tests\BaseTestCase;
use Tests\fixtures\Models\User;
use Tests\fixtures\Notifications\WelcomeNotification;

class PreviewTest extends BaseTestCase {


    /**
     * @test
     */
    public function can_preview_notification () {
        WelcomeNotification::preview(new User());
    }

}
