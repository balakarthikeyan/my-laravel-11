<?php

namespace App\Providers;

use App\Helpers\Helper;
use App\Services\CustomService;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CustomFacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('testfacade', function ($app) {
            return new CustomService();
        });

        // $this->app->singleton('testfacade', function ($app) {
        //     return new Helper();
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
		Collection::macro('pluralize', function () {
			return $this->map(function ($value) {
				 return Str::plural($value);
			});
		});
    }
}
