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


//DashBoard =======================
Route::get('dashboard', 'DashBoard\HomeController@index');

Route::get('dashboard/login', 'DashBoard\LoginController@index');
Route::post('dashboard/login', 'DashBoard\LoginController@postLogin');

Route::get('dashboard/register', 'DashBoard\HomeController@getRegister');
Route::post('dashboard/register', 'DashBoard\HomeController@postRegister');

//Model
Route::resource('dashboard/models', 'DashBoard\ModelController');

//Movie
Route::resource('dashboard/movies', 'DashBoard\MovieController');

//Music
Route::resource('dashboard/musics', 'DashBoard\MusicController');

//tag
Route::resource('dashboard/tags', 'DashBoard\TagController');

//category
Route::resource('dashboard/cates', 'DashBoard\CategoryController');

//Article
Route::resource('dashboard/articles', 'DashBoard\ArticleController');

//fix
Route::resource('dashboard/fixes', 'DashBoard\FixController');

Route::get('dashboard/movieup', 'DashBoard\HomeController@getMovieup');
//Route::get('dashboard/movieup', function() {
//  $client = new Google_Client();
//  return var_dump($client);
//});

Route::get('dashboard/twtup', 'DashBoard\HomeController@getTwtup');

Route::get('dashboard/fbup', 'DashBoard\HomeController@getFbup');

Route::get('dashboard/logout', 'DashBoard\HomeController@getLogout');


// Model Contribute===============
//login
$this->get('contribute/login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('contribute/login', 'Auth\LoginController@login');
$this->get('contribute/logout', 'Auth\LoginController@logout')->name('logout');

//register
$this->get('contribute/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('contribute/register', 'Auth\RegisterController@register');


Auth::routes();

//Route::get('/home', 'HomeController@index');
