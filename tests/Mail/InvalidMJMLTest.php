<?php


namespace Mail;

use ModernMail\Exception\MJMLValidationFailedException;
use Tests\BaseTestCase;
use Tests\fixtures\Models\User;
use Tests\fixtures\Notifications\InvalidMjmlNotification;

class InvalidMJMLTest extends BaseTestCase {


    /**
     * @test
     */
    public function invalidMjmlThrowsException () {
        try {
            InvalidMjmlNotification::preview(new User());
        } catch (\Exception $e) {
            self::assertInstanceOf(MJMLValidationFailedException::class, $e);
        }
    }

}
