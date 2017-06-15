<?php

namespace App\Providers;

use App\Music;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    
        Validator::extend('audio', function ($attribute, $value, $parameters, $validator) {
        	echo $value->getClientOriginalName();
            var_dump($value);
            exit;
            return $value == 'foo';
        });
        
        Validator::extend('secondcheck', function ($attribute, $value, $parameters, $validator) {
        	//print_r($value); //秒数 input moviesec[]
            $sum = $parameters[0]; //musicId
            
            //$sum = array_sum($value);
            
            //if($musicId) {
            	return $sum < Music::find($value)->second;
            //}
            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
