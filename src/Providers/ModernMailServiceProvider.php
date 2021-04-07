<?php

namespace ModernMail\Providers;

use Illuminate\Support\ServiceProvider;

class ModernMailServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $viewPath = dirname(__DIR__, 2) .'/resources/views/mjml';
        $namespace = 'mjml';
        $this->loadViewsFrom($viewPath, $namespace);

        $this->publishes([
            $viewPath => resource_path('views/vendor/' . $namespace),
        ]);
    }

}
