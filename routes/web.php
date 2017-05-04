<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Main\HomeController@index');

Route::get('hello', function () {
    echo "hello2";
});

Route::get('info', function () {
    phpinfo();
});


//DashBoard
Route::get('dashboard', 'DashBoard\HomeController@index');

Route::get('dashboard/login', 'DashBoard\LoginController@index');
Route::post('dashboard/login', 'DashBoard\LoginController@postLogin');

Route::get('dashboard/register', 'DashBoard\HomeController@getRegister');
Route::post('dashboard/register', 'DashBoard\HomeController@postRegister');

Route::resource('dashboard/model', 'DashBoard\ModelController');

Route::resource('dashboard/fixes', 'DashBoard\FixController');

Route::get('dashboard/movieup', 'DashBoard\HomeController@getMovieup');
//Route::get('dashboard/movieup', function() {
//  $client = new Google_Client();
//  return var_dump($client);
//});

Route::get('dashboard/twtup', 'DashBoard\HomeController@getTwtup');

Route::get('dashboard/fbup', 'DashBoard\HomeController@getFbup');

Route::get('dashboard/logout', 'DashBoard\HomeController@getLogout');

//Article
Route::resource('dashboard/articles', 'DashBoard\ArticleController');




Auth::routes();

//Route::get('/home', 'HomeController@index');
