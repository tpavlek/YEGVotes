<?php

namespace Depotwarehouse\YEGVotes\Providers;

use Illuminate\Support\ServiceProvider;
use Laracasts\Utilities\JavaScript\LaravelViewBinder;
use Laracasts\Utilities\JavaScript\PHPToJavaScriptTransformer;
use Laracasts\Utilities\JavaScript\ViewBinder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PHPToJavaScriptTransformer::class, function ($app) {
            return $app->make('JavaScript');
        });
    }
}
