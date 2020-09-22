<?php

namespace Paksuco\Language;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleConfigs();
        // $this->handleMigrations();
        $this->handleViews();
        // $this->handleTranslations();
        $this->handleRoutes();

        Event::listen("paksuco.menu.beforeRender", function ($key, $container) {
            if ($key == "admin") {
                $container->addItem("Language", route("paksuco.language.admin"), "fa fa-brush");
            }
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bind any implementations.
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function handleConfigs()
    {
        $configPath = __DIR__ . '/../config/paksuco-language.php';

        $this->publishes([$configPath => base_path('config/paksuco-language.php')]);

        $this->mergeConfigFrom($configPath, 'paksuco-language');
    }

    private function handleTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'paksuco-language');
    }

    private function handleViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'paksuco-language');
        $this->publishes([__DIR__ . '/../views' => base_path('resources/views/paksuco/language')]);
    }

    private function handleMigrations()
    {
        $this->publishes([__DIR__ . '/../migrations' => base_path('database/migrations')]);
    }

    private function handleRoutes()
    {
        include __DIR__ . '/../routes/routes.php';
    }
}

if (!function_exists("base_path")) {
    function base_path($path)
    {
        return \Illuminate\Support\Facades\App::basePath($path);
    }
}
