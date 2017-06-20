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
    
        Validator::extend('filenaming', function ($attribute, $value, $parameters, $validator) {
        	$name = $value->getClientOriginalName();
            //echo $name;
            //print_r($value);
            
            return preg_match("/^[a-zA-Z0-9._-]+$/", $name);
            
        });
        
        
        Validator::extend('secondcheck', function ($attribute, $value, $parameters, $validator) {
        	//print_r($value); //秒数 input moviesec[]
            $sum = $parameters[0]; //inputの合計値
            
            //$sum = array_sum($value);
            
            //if($musicId) {
            	return ($sum+15) < Music::find($value)->second;
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
