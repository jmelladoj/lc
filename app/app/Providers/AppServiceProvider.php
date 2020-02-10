<?php

namespace App\Providers;

use App\Servicio;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $cantidad_servicios = Servicio::get()->count();

        View::share('cantidad_servicios', $cantidad_servicios);
        date_default_timezone_set('America/Santiago');
    }
}
