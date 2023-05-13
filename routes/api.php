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

//sRoute::get('/get/news', 'App\Http\Controllers\APIController@getNews');

Route::get('/ks/cats', 'App\Http\Controllers\APIController@getKSCats');



//API COPS



//Get Branches Category
Route::get('/branchesCat/', 'App\Http\Controllers\APIController@getBranchesCat');

//Get Branches
Route::get('/branches/', 'App\Http\Controllers\APIController@getBranches');
Route::get('/branches/{id}', 'App\Http\Controllers\APIController@getBranchesbyId');

//Get Branches list By Branch Category
Route::get('/branchesByCat/{catid}', 'App\Http\Controllers\APIController@getBranchesByBranchCatId');

// GET NEWS
Route::get('/news/', 'App\Http\Controllers\APIController@getNews');
Route::get('/news/{id}', 'App\Http\Controllers\APIController@getNewsbyId');

// GET offers
Route::get('/offers/', 'App\Http\Controllers\APIController@getOffersFestivals');

//Route::get('/offers/', 'App\Http\Controllers\APIController@getOffersFestivals');


Route::get('/offers/{id}', 'App\Http\Controllers\APIController@getOffersFestivalsByID');

Route::get('/offersFestivalsImage/{id}', 'App\Http\Controllers\APIController@getOffersFestivalsImagesDet');


// GET Coupen offers Category
Route::get('/coupenOffersCat/', 'App\Http\Controllers\APIController@getCoupenOffersCat');

// GET Coupen offers
Route::get('/coupenOffers/', 'App\Http\Controllers\APIController@getCoupenOffers');
Route::get('/coupenOffers/{id}', 'App\Http\Controllers\APIController@getCoupenOffersById');

//Get Couper offer list By Category
Route::get('/coupenOffesByCat/{id}', 'App\Http\Controllers\APIController@getCoupenOffersByCatID');

//Get Gallaries Cate Name
Route::get('/galleriesCatName/', 'App\Http\Controllers\APIController@getGallaeriesCatName');

//Get Gallaries  Photos By Cat ID
Route::get('/galleriesPhotosByCatID/{id}', 'App\Http\Controllers\APIController@getGallaeriesPhotoByCatID');

//Get Gallaries
Route::get('/galleries/', 'App\Http\Controllers\APIController@getGallaeriesCatName');

//Get Social Media
Route::get('/socialMedia/', 'App\Http\Controllers\APIController@getSocialMedia');

//Get Directors 
Route::get('/directors/', 'App\Http\Controllers\APIController@getDirectors');

//Create Complaints
Route::post('/Complaint/Create/', 'App\Http\Controllers\APIController@CreateComplaint');

//Discard Reports
Route::post('/DiscardReport/Create/', 'App\Http\Controllers\APIController@CreateDiscardReport');


//getSlideShows
Route::get('/slideShows/', 'App\Http\Controllers\APIController@getSlideShows');

//Get Family Data 

//Route::get('/familyData/{civilid}', 'App\Http\Controllers\APIController@getFamilyCardBarCodeImage');

Route::get('/familyData/', 'App\Http\Controllers\APIController@getFamilyCardBarCodeImage');

//Route::get('/ShareHolderProfit/{civilid}/{box_no}', 'App\Http\Controllers\APIController@getShareHolderProfit');


Route::get('/ShareHolderProfit/', 'App\Http\Controllers\APIController@getShareHolderProfit');

//Shareholder Profit Title
Route::get('/ShareHolderProfitTitle/', 'App\Http\Controllers\APIController@getShareHolderProfitTitle');


//about us 
Route::get('/aboutus/', 'App\Http\Controllers\APIController@getaboutUS');


//getALLData
Route::get('/getAlldata/', 'App\Http\Controllers\APIController@getDataFromAllTables');


Route::get('/productByName/', 'App\Http\Controllers\APIController@getProductByItemName');

Route::get('/productByItemBarCode/', 'App\Http\Controllers\APIController@getProductByItemBarCode');


Route::post('/storeDeviceFCMToken/', 'App\Http\Controllers\APIController@storeDeviceFCMToken');


