<?php

namespace Asmi\JsonLd;

use Asmi\JsonLd\Contracts\RenderableJsonLdInterface;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class JsonLdServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/jsonld.php', 'jsonld');

        $this->app->singleton('jsonld', function ($app) {
            return new JsonLdManager();
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/jsonld.php' => config_path('jsonld.php'),
            ], 'jsonld-config');
        }

        // Register Blade directive
        $this->registerBladeDirective();
    }

    protected function registerBladeDirective(): void
    {
        Blade::directive('jsonld', function ($expression) {
            $interface = RenderableJsonLdInterface::class;

            return "<?php if ({$expression} instanceof \\{$interface}) { echo {$expression}->render(); } ?>";
        });
    }
}
