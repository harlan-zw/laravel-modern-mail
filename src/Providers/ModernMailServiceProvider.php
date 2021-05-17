<?php

namespace ModernMail\Providers;

use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\ServiceProvider;
use ModernMail\Notifications\Channels\ModernMailChannel;
use ModernMail\Process\HtmlToText;
use ModernMail\Process\MJML;
use PHPUnit\TextUI\XmlConfiguration\Logging\TestDox\Html;

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

        $this->app->bind(HtmlToText::class, function () {
            return new HtmlToText(config('modern-mailer.html_to_text_options'));
        });

        $this->app->bind(MJML::class, function () {
            switch(config('modern-mailer.mjml_binary_mode')) {
                case 'binary':
                    return MJML::viaBinary(config('modern-mailer.mjml_binary_path'));
                case 'node_module':
                    return MJML::viaNodeModule();
                case 'detect':
                default:
                    return MJML::detectMode();
            }
        });
    }

}
