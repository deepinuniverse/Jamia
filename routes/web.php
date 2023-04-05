<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::group(['middleware' => 'auth'], function () {

	//jamaia
    Route::resource('/directors','App\Http\Controllers\DirectorController');
    Route::post('/directors/update','App\Http\Controllers\DirectorController@update');
    Route::get('/directors/delete/{id}', 'App\Http\Controllers\DirectorController@destroy')->name('directors.delete');
    Route::get('/directors/view/list','App\Http\Controllers\DirectorController@view');

    Route::resource('/news','App\Http\Controllers\NewsDetailsController');
	Route::get('/news/edit/{id}', 'App\Http\Controllers\NewsDetailsController@edit')->name('news.edit');
    Route::post('/news/update','App\Http\Controllers\NewsDetailsController@update');
	Route::get('/news/destroy/{id}', 'App\Http\Controllers\NewsDetailsController@destroy')->name('news.delete');
	Route::get('/news/view/{id}','App\Http\Controllers\NewsDetailsController@ViewNews');

	Route::resource('/offers','App\Http\Controllers\OfferController');
	Route::post('/offers/update','App\Http\Controllers\OfferController@update');
	Route::get('/offers/destroy/{id}', 'App\Http\Controllers\OfferController@destroy')->name('offers.delete');
	Route::get('/offers/view/list/{id}','App\Http\Controllers\OfferController@view');

	Route::resource('/branch_category','App\Http\Controllers\BranchCategoryController');
	Route::post('/branch_category/update','App\Http\Controllers\BranchCategoryController@update');
	Route::get('/branch_category/destroy/{id}', 'App\Http\Controllers\BranchCategoryController@destroy')->name('branch.category.delete');

	Route::resource('/discard_report','App\Http\Controllers\DiscardReportController');
	Route::post('/discard_report/update','App\Http\Controllers\DiscardReportController@update');
	Route::get('/discard_report/destroy/{id}', 'App\Http\Controllers\DiscardReportController@destroy')->name('discard.report.delete');

	Route::resource('/offer_category','App\Http\Controllers\OfferCategoryController');
	Route::post('/offer_category/update','App\Http\Controllers\OfferCategoryController@update');
	Route::get('/offer_category/destroy/{id}', 'App\Http\Controllers\OfferCategoryController@destroy')->name('offer.category.delete');

	Route::resource('/coupon_offer','App\Http\Controllers\CouponOfferController');
	Route::post('/coupon_offer/update','App\Http\Controllers\CouponOfferController@update');
	Route::get('/coupon_offer/destroy/{id}', 'App\Http\Controllers\CouponOfferController@destroy')->name('coupon.offer.delete');
    Route::get('/coupon/offer/view/{id}','App\Http\Controllers\CouponOfferController@View');

	Route::resource('/complaints','App\Http\Controllers\ComplaintController');
	Route::post('/complaints/update','App\Http\Controllers\ComplaintController@update');
	Route::get('/complaints/destroy/{id}', 'App\Http\Controllers\ComplaintController@destroy')->name('complaints.delete');

	Route::resource('/galleries','App\Http\Controllers\GalleryController');
    Route::post('/galleries/update','App\Http\Controllers\GalleryController@update');
    Route::get('/galleries/destroy/{id}', 'App\Http\Controllers\GalleryController@destroy')->name('galleries.delete');
    Route::get('/galley/photo/destroy/{id}', 'App\Http\Controllers\GalleryController@destroyPhoto')->name('galley.photo.delete');

	Route::resource('/medias','App\Http\Controllers\SocialmediaController');
	Route::get('/medias/destroy/{id}', 'App\Http\Controllers\SocialmediaController@destroy')->name('medias.delete');

	Route::resource('/branches','App\Http\Controllers\BranchController');
	Route::post('/branches/update','App\Http\Controllers\BranchController@update');
    Route::get('/branches/destroy/{id}', 'App\Http\Controllers\BranchController@destroy')->name('branches.delete');
	//
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	

	Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::resource('/brands','App\Http\Controllers\BrandController');
	Route::resource('/products','App\Http\Controllers\ProductController');
	Route::resource('/categories','App\Http\Controllers\CategoryController');
	Route::get('/vendors','App\Http\Controllers\UserController@vendors');
	Route::get('/vendors/create','App\Http\Controllers\UserController@createVendor');
	Route::post('/vendors/store','App\Http\Controllers\UserController@storeVendor');
	Route::get('/vendors/edit','App\Http\Controllers\UserController@editVendor');
	Route::post('/vendors/update','App\Http\Controllers\UserController@updateVendor');
	Route::post('/vendors/delete','App\Http\Controllers\UserController@deleteVendor');

		
	Route::delete('/brands/{id}', 'App\Http\Controllers\BrandController@destroy')->name('brand.delete');
	Route::delete('/categories/{id}', 'App\Http\Controllers\CategoryController@destroy')->name('category.delete');
	Route::get('/poll/create','App\Http\Controllers\PollController@create');
	Route::get('/poll','App\Http\Controllers\PollController@index');
	Route::post('/poll/store','App\Http\Controllers\PollController@store');

	Route::resource('/news_category','App\Http\Controllers\NewsCategoryController');
	Route::post('/news_category/update','App\Http\Controllers\NewsCategoryController@update');
	Route::delete('/news_category/delete/{id}', 'App\Http\Controllers\NewsCategoryController@destroy')->name('news.category.delete');

	Route::resource('/sports_category','App\Http\Controllers\SportsCategoryController');
	Route::post('/sports_category/update','App\Http\Controllers\SportsCategoryController@update');
	Route::delete('/sports_category/delete/{id}', 'App\Http\Controllers\SportsCategoryController@destroy')->name('sports.category.delete');

	Route::resource('/seasons','App\Http\Controllers\SeasonController');
	Route::post('/seasons/update','App\Http\Controllers\SeasonController@update');
	Route::delete('/seasons/delete/{id}', 'App\Http\Controllers\SeasonController@destroy')->name('seasons.delete');

	Route::resource('/teams','App\Http\Controllers\TeamController');
	Route::post('/teams/update','App\Http\Controllers\TeamController@update');
	Route::get('/teams/delete/{id}', 'App\Http\Controllers\TeamController@destroy')->name('teams.delete');
	
    Route::resource('/tournaments','App\Http\Controllers\TournamentController');
    Route::post('/tournaments/update','App\Http\Controllers\TournamentController@update');
	Route::get('/tournaments/delete/{id}', 'App\Http\Controllers\TournamentController@destroy')->name('tournaments.delete');

	Route::resource('/players','App\Http\Controllers\PlayerController');
	Route::post('/players/update','App\Http\Controllers\PlayerController@update');
	Route::get('/players/delete/{id}', 'App\Http\Controllers\PlayerController@destroy')->name('players.delete');
    Route::get('players/view/{id}','App\Http\Controllers\PlayerController@view');
    
	

	Route::resource('/schedules','App\Http\Controllers\ScheduleController');
	Route::post('/schedules/update','App\Http\Controllers\ScheduleController@update');
	Route::get('/schedules/destroy/{id}', 'App\Http\Controllers\ScheduleController@destroy')->name('schedules.delete');
	Route::get('/schedules/view/{id}', 'App\Http\Controllers\ScheduleController@view')->name('schedules.view');
    Route::get('/get/team/list{id}', 'App\Http\Controllers\ScheduleController@teamList')->name('team.list');

	Route::resource('/matches','App\Http\Controllers\MatchController');
	Route::post('/matches/update','App\Http\Controllers\MatchController@update');
	Route::get('/matches/destroy/{id}', 'App\Http\Controllers\MatchController@destroy')->name('matches.delete');
	Route::get('/matches/players/{m_id}', [ 'as' => 'matches.players',
    'uses' => 'App\Http\Controllers\MatchController@playersAdd']);
    Route::get('/get/players/{id}', [ 'as' => 'get.players',
    'uses' => 'App\Http\Controllers\MatchController@getPlayers']);

    Route::get('/matches/save/players','App\Http\Controllers\MatchController@savePlayers');
    Route::get('/matches/players/delete/{id}','App\Http\Controllers\MatchController@matchPlayersDel');
    Route::get('/matches/players/view/{id}','App\Http\Controllers\MatchController@ViewMatch');
	Route::get('/get/schedule/playerlist/{id}','App\Http\Controllers\MatchController@getPlayersList');
	Route::resource('/roles','App\Http\Controllers\RoleController');
	Route::post('/roles/update','App\Http\Controllers\RoleController@update');
	Route::get('/roles/destroy/{id}', 'App\Http\Controllers\RoleController@destroy')->name('roles.delete');

	Route::get('/user/list', 'App\Http\Controllers\UserController@userIndex')->name('user.list');
	

	Route::get('/userlist/create', 'App\Http\Controllers\UserController@createUser')->name('user.list.create');
	Route::post('/users_list/add','App\Http\Controllers\UserController@userStore');
	Route::get('/userlist/edit/{id}', 'App\Http\Controllers\UserController@editUser')->name('user.list.edit');
	Route::post('/users_list/update','App\Http\Controllers\UserController@userUpdate');
    Route::get('/users_list/destroy/{id}', 'App\Http\Controllers\UserController@destroy')->name('users.list.delete');

    
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
