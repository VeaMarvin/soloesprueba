<?php

namespace App\Providers;

use App\Comment;
use App\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);

        //Variables globales para utilizar en el Blade de Header ubicado en views/partials/header
        view()->composer('partials.header', function ($view) {
            $contar_comentarios = Comment::all()->count();
            $view->with('comentarios', $contar_comentarios);
        });

        view()->composer('partials.header', function ($view) {
            $nombre_empresa = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->name : '';
            $view->with('nombre_empresa', $nombre_empresa);
        });

        view()->composer('partials.header', function ($view) {
            $slogan = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->slogan : '';
            $view->with('slogan', $slogan);
        });

        view()->composer('partials.header', function ($view) {
            $logotipo = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->logotipo : '';
            $view->with('logotipo', $logotipo);
        });

        view()->composer('partials.header', function ($view) {
            $facebook = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->facebook : '';
            $view->with('facebook', $facebook);
        });

        view()->composer('partials.header', function ($view) {
            $twitter = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->twitter : '';
            $view->with('twitter', $twitter);
        });

        view()->composer('partials.header', function ($view) {
            $instagram = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->instagram : '';
            $view->with('instagram', $instagram);
        });

        view()->composer('partials.header', function ($view) {
            $page = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->page : '';
            $view->with('page', $page);
        });

        //Variables globales para utilizar en el Blade de Index ubicado en views/shop/index
        view()->composer('shop.index', function ($view) {
            $nombre_empresa = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->name : '';
            $view->with('nombre_empresa', $nombre_empresa);
        });

        //Variables globales para utilizar en el Blade de Header ubicado en views/partials/footer
        view()->composer('partials.footer', function ($view) {
            $nombre_empresa = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->name : '';
            $view->with('nombre_empresa', $nombre_empresa);
        });

        view()->composer('partials.footer', function ($view) {
            $slogan = !is_null(Company::where('current',true)->first()) ? Company::where('current',true)->first()->slogan : '';
            $view->with('slogan', $slogan);
        });
    }
}
