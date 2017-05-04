<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->get('/users', function (Request $request) {
//     return App\User::all();
// });

// Route::group(['middleware' => 'auth:api', 'prefix' => 'v1','namespace' => 'Api\v1'], function () {
Route::group(['prefix' => 'v1','namespace' => 'Api\v1'], function () {
    // Route::get('users/{id?}',  'ApiController@users');
    Route::resource('users', 'UserController');
    Route::resource('asset', 'AssetController');
    Route::resource('campus', 'CampusController');
    Route::resource('building', 'BuildingController');
    Route::resource('room', 'RoomController');
    Route::resource('software', 'SoftwareController');
    Route::resource('support', 'SupportController');
    Route::resource('category', 'CategoryController');
    Route::resource('properties', 'PropertiesController');
    Route::resource('asset-property-name', 'AssetPropertyNameController');
    Route::resource('media', 'MediaController');
});





// Route::middleware('auth:api')->resource('test', 'ExampleController');


