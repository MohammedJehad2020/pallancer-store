<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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

        Validator::extend(
            'filter', // custom rule name
            function($attribute, $value, $params){     // clusore function for filter
                foreach($params as $word){
                    if(stripos($value, $word) !== false){
                        return false;    
                    }
                }
                return true;
        },
         'Invalid Word!', // error message
        );
    }
}
