<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login','App\Http\Controllers\APIController@login');
Route::get('/metadata','App\Http\Controllers\APIController@shopMetaData');
Route::post('/register','App\Http\Controllers\APIController@register');


Route::get('/getAllBrands','App\Http\Controllers\APIController@getAllBrands');
Route::get('/getAllCategories','App\Http\Controllers\APIController@getAllCategories');

Route::get('/products','App\Http\Controllers\APIController@getProdcuts');

Route::get('/getProductsByVenodrID/{uid}','App\Http\Controllers\APIController@getProductsByVenodrID');

Route::post('/translate','App\Http\Controllers\APIController@translate');
Route::get('/players/poll','App\Http\Controllers\APIController@getPlyersPolls');
Route::get('/open/poll/{id}','App\Http\Controllers\APIController@openPoll');
Route::post('/players/poll/vote','App\Http\Controllers\APIController@votePlayer');
//api to save leagues
Route::post('/save/leagues', 'App\Http\Controllers\APIController@saveLeagues');
Route::get('/get/leagues', 'App\Http\Controllers\APIController@getLeagues');

Route::get('/get/news', 'App\Http\Controllers\APIController@getNews');

Route::get('/ks/cats', 'App\Http\Controllers\APIController@getKSCats');






