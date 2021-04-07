<?php

namespace Tests\Process;

use ModernMail\Process\MJML;
use Tests\BaseTestCase;

class MJMLTest extends BaseTestCase {

    /**
     * @test
     */
    public function can_render() {
        $view = $this->mjml('basic', [
            'name' => 'mjml test',
            'title' => 'test',
            'siteUrl' => 'test',
        ]);

        $this->assertMatchesHtmlSnapshot($view->toHtml());
    }

}
