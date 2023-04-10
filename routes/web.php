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
	

	Route::resource('/news_category','App\Http\Controllers\NewsCategoryController');
	Route::post('/news_category/update','App\Http\Controllers\NewsCategoryController@update');
	Route::delete('/news_category/delete/{id}', 'App\Http\Controllers\NewsCategoryController@destroy')->name('news.category.delete');

	Route::resource('/roles','App\Http\Controllers\RoleController');
	Route::post('/roles/update','App\Http\Controllers\RoleController@update');
	Route::get('/roles/destroy/{id}', 'App\Http\Controllers\RoleController@destroy')->name('roles.delete');

	Route::get('/user/list', 'App\Http\Controllers\UserController@userIndex')->name('user.list');
	

	Route::get('/userlist/create', 'App\Http\Controllers\UserController@createUser')->name('user.list.create');
	Route::post('/users_list/add','App\Http\Controllers\UserController@userStore');
	Route::get('/userlist/edit/{id}', 'App\Http\Controllers\UserController@editUser')->name('user.list.edit');
	Route::post('/users_list/update','App\Http\Controllers\UserController@userUpdate');
    Route::get('/users_list/destroy/{id}', 'App\Http\Controllers\UserController@destroy')->name('users.list.delete');

    Route::resource('/coupon_user','App\Http\Controllers\CouponUserController');
	Route::post('/coupon_user/update','App\Http\Controllers\CouponUserController@update');
    Route::get('/coupon_user/destroy/{id}', 'App\Http\Controllers\CouponUserController@destroy')->name('coupon.user.delete');

    
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
