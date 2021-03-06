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

//if(Schema::hasTable('states')) {
//    $states = DB::table('states')->get();
//    foreach($states as $state) {
//        Route::group(['prefix' => $state->slug], function(){
//        	Route::get('/', 'Main\HomeController@index');
//            //Route::get('{tagSlug}', 'Main\TagController@show');
//        });
//    }
//}


Route::get('/m/{id}', function(){
	abort(404);
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

//Setting
Route::resource('dashboard/settings', 'DashBoard\SettingController');

//State
Route::resource('dashboard/states', 'DashBoard\StateController');

//Model
Route::resource('dashboard/models', 'DashBoard\ModelController');

//ModelMovie
Route::resource('dashboard/model-movies', 'DashBoard\ModelMovieController');

//Movie
Route::resource('dashboard/movies', 'DashBoard\MovieController');

//Music
Route::resource('dashboard/musics', 'DashBoard\MusicController');

//Tag
Route::resource('dashboard/tags', 'DashBoard\TagController');

//Category
Route::resource('dashboard/cates', 'DashBoard\CategoryController');

//FeatureCategory
Route::resource('dashboard/featurecates', 'DashBoard\FeatureCateController');

//Article
Route::get('dashboard/articles/snsup/{atclId}', 'DashBoard\ArticleController@getSnsUp');
Route::post('dashboard/articles/snsup/{atclId}', 'DashBoard\ArticleController@postSnsUp');
Route::get('dashboard/articles/ytup', 'DashBoard\ArticleController@getYtUp');
Route::get('dashboard/articles/twfbup', 'DashBoard\ArticleController@getTwFbUp');
//Route::post('dashboard/articles/ytup', 'DashBoard\ArticleController@postYtUp');
Route::post('dashboard/articles/twitter', 'DashBoard\ArticleController@postTwitter');
Route::resource('dashboard/articles', 'DashBoard\ArticleController');

//Feature
Route::resource('dashboard/features', 'DashBoard\FeatureController');

//Fix
Route::resource('dashboard/fixes', 'DashBoard\FixController');

//Contact
Route::get('dashboard/contacts/cate/{cateId}', 'DashBoard\ContactController@getEditCate');
Route::post('dashboard/contacts/cate/{cateId}', 'DashBoard\ContactController@postEditCate');
Route::resource('dashboard/contacts', 'DashBoard\ContactController');


//Other
Route::get('dashboard/movieup', 'DashBoard\HomeController@getMovieup');
//Route::get('dashboard/movieup', function() {
//  $client = new Google_Client();
//  return var_dump($client);
//});

Route::get('dashboard/twtup', 'DashBoard\HomeController@getTwtup');

Route::get('dashboard/fbup', 'DashBoard\HomeController@getFbup');

Route::get('dashboard/logout', 'DashBoard\HomeController@getLogout');


// Model Contribute ===============
//login
$this->get('contribute/login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('contribute/login', 'Auth\LoginController@login');
$this->post('contribute/logout', 'Auth\LoginController@logout')->name('logout');
//$this->post('contribute/logout', 'Model\HomeController@logout')->name('logout');

//register
$this->get('contribute/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('contribute/register', 'Auth\RegisterController@register');

//Reset
$this->get('contribute/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('contribute/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$this->get('contribute/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$this->post('contribute/password/reset', 'Auth\ResetPasswordController@reset');

//Index
//Route::post('contribute/item', 'Model\HomeController@postItem');
//Route::post('contribute/movie', 'Model\HomeController@postMovie');
Route::get('contribute/finish', 'Model\HomeController@getFinish');
Route::resource('contribute', 'Model\HomeController');




//Main All ==================================
//Contact
Route::resource('contact', 'Main\ContactController');

//Fix Page
use App\Fix;
$fixes = Fix::where('open_status', 1)->get();
foreach($fixes as $fix) {
	Route::get($fix->slug, 'Main\HomeController@getFix');
}

//Search
Route::get('search', 'Main\SearchController@index');

//State
Route::get('/{state?}', 'Main\HomeController@index');


//Feature
Route::get('{state}/feature', 'Main\FeatureController@index');
Route::get('{state}/feature/{cate}', 'Main\FeatureController@showCate');
Route::get('{state}/feature/{cate}/{id}', 'Main\FeatureController@showSingle'); //Feature Single Page

//Model
Route::get('{state}/model', 'Main\ModelController@index');
Route::get('{state}/model/{id}', 'Main\ModelController@showSingle');

//Tag
Route::get('{state}/tag/{tag}', 'Main\HomeController@showTag');

//Category
Route::get('{state}/{cate}', 'Main\HomeController@showCate');
Route::get('{state}/{cate}/{id}', 'Main\HomeController@showSingle'); //Atcl Single Page









Auth::routes();

//Route::get('/home', 'HomeController@index');
