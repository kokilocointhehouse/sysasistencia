<?php
namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

        view()->composer('*', function ()
         {
        if (isset(Auth::user()->IdUsuario)){
            $mytime = Carbon::now();
            $fecha = $mytime->toDateString();
            $informe=DB::table('registro')
            ->where('FechaRegistro', '=', $fecha)
            ->where('IdUsuario', '=', Auth::user()->IdUsuario)
            ->first();
            //...with this variable
            View::share('alert', $informe );
        }

        });


    }
}
