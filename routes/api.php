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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->get('/users', function (Request $request) {
//     return App\User::all();
// });

Route::group(['prefix' => 'v1','namespace' => 'Api\v1'], function () {
    Route::middleware('auth:api')->resource('user', 'UserController');
    Route::middleware('auth:api')->resource('asset', 'AssetController');
    Route::middleware('auth:api')->resource('campus', 'CampusController');
    Route::middleware('auth:api')->resource('building', 'BuildingController');
    Route::middleware('auth:api')->resource('room', 'RoomController');
    Route::middleware('auth:api')->resource('software', 'SoftwareController');
    Route::middleware('auth:api')->resource('support', 'SupportController');
    Route::middleware('auth:api')->resource('category', 'CategoryController');
    Route::middleware('auth:api')->resource('properties', 'PropertiesController');
    Route::middleware('auth:api')->resource('asset-property-name', 'AssetPropertyNameController');
    Route::middleware('auth:api')->resource('media', 'MediaController');
});





// Route::middleware('auth:api')->resource('test', 'ExampleController');


