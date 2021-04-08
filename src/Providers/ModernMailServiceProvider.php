<?php

namespace ModernMail\Providers;

use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\ServiceProvider;
use ModernMail\Notifications\Channels\ModernMailChannel;

class ModernMailServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(dirname(__DIR__, 2).'/config/modern-mailer.php', 'modern-mailer');
    }

    public function boot()
    {

        $viewPath = dirname(__DIR__, 2) .'/resources/views/mjml';
        $namespace = 'mjml';
        $this->loadViewsFrom($viewPath, $namespace);

        $this->publishes([
            $viewPath => resource_path('views/vendor/' . $namespace),
        ]);

        $this->app->bind(MailChannel::class, function () {
            return $this->app->make(ModernMailChannel::class);
        });
    }

}
