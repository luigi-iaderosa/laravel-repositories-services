<?php

namespace App\Providers;

use App\Repos\ArticleNoUserLoggedRepo;
use App\Repos\ArticleRepoInterface;
use App\Repos\ArticleUserLoggedRepo;
use App\Services\ArticleNoUserLoggedService;
use App\Services\ArticleServiceInterface;
use App\Services\ArticleUserLoggedService;
use App\Services\PurchaseService;
use App\Services\PurchaseServiceInterface;
use Illuminate\Support\Facades\Auth;
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


        $this->app->bind(ArticleRepoInterface::class,function($app){
            $authUser = Auth::user();
            if ($authUser){
                $articleRepo = new ArticleUserLoggedRepo();
                return $articleRepo;
            }
            else {
                $articleRepo = new ArticleNoUserLoggedRepo();
                return $articleRepo;
            }
        });

        $this->app->bind(ArticleServiceInterface::class,function($app){
            $authUser = Auth::user();
            $articleRepo = $this->app->make(ArticleRepoInterface::class);
            if ($authUser){
                return new ArticleUserLoggedService($articleRepo);
            }
            else {

                return new ArticleNoUserLoggedService($articleRepo);
            }
        });



        $this->app->bind(PurchaseServiceInterface::class,function($app){
            $authUser = Auth::user();
            return new PurchaseService($authUser);
        });



    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
