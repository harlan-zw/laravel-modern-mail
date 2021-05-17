<?php

namespace Tests;

use Illuminate\Support\Facades\View as ViewFacade;
use KirschbaumDevelopment\MailIntercept\WithMailInterceptor;
use ModernMail\Providers\ModernMailServiceProvider;
use Orchestra\Testbench\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

abstract class BaseTestCase extends TestCase
{
    use MatchesSnapshots,
        WithMailInterceptor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('view:clear');


        ViewFacade::addLocation(__DIR__ . '/fixtures/resources/views');
    }

    protected function defineEnvironment($app)
    {
        // make sure testbench can find the mjml binary
        $app['config']->set('modern-mailer.mjml_validate', 'error');
        $app['config']->set('modern-mailer.mjml_binary_mode', 'binary');
        $app['config']->set('modern-mailer.mjml_binary_path', dirname(__DIR__) . '/mjml');
    }

    protected function getPackageProviders($app): array
    {
        return [ModernMailServiceProvider::class];
    }

}
