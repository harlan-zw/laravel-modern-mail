<?php

namespace Tests;

use Illuminate\Support\Facades\View as ViewFacade;
use ModernMail\Providers\ModernMailServiceProvider;
use Orchestra\Testbench\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

abstract class BaseTestCase extends TestCase
{
    use RendersMJML,
        MatchesSnapshots;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('view:clear');

        ViewFacade::addLocation(__DIR__ . '/resources/views');
    }

    protected function getPackageProviders($app): array
    {
        return [ModernMailServiceProvider::class];
    }

}
