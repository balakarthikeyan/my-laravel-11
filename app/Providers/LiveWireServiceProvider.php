<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Jetstream\Http\Livewire\NavigationMenu;

class LiveWireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function () {
            if (config('jetstream.stack') === 'livewire' && class_exists(Livewire::class)) {
                Livewire::component('navigation-menu', NavigationMenu::class);
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Livewire::component('navigation-menu', NavigationMenu::class);
    }
}
