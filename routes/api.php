<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1', 'namespace' => 'Api\v1'], function () {

// Route::group(['prefix' => 'v1','namespace' => 'Api\v1'], function () {

    Route::resource('users', 'UserController');
    Route::post('users/{user}/sync/departments', 'UserController@syncDepartments');
    Route::post('users/{user}/sync/roles', 'UserController@syncRoles');
    Route::get('currentuser', 'UserController@currentUser');

    // Route::get('inventory', 'UserController@currentUser');


    Route::resource('asset', 'AssetController');
    Route::get('inventory', 'AssetController@index');

    Route::resource('departments', 'DepartmentController');

    Route::resource('org', 'OrgController');

    Route::resource('roles', 'RoleController');

    Route::resource('campus', 'CampusController');

    Route::resource('buildings', 'BuildingController');

    Route::resource('rooms', 'RoomController');
    Route::post('rooms/{room}/sync/departments', 'RoomController@syncDepartments');
    Route::post('rooms/{room}/sync/supports', 'RoomController@syncSupports');

    Route::resource('roomstyle', 'RoomStyleController');

    Route::resource('software', 'SoftwareController');

    Route::resource('support', 'SupportController');

    Route::resource('category', 'CategoryController');

    Route::resource('properties', 'PropertiesController');

    Route::resource('property-name', 'PropertyNameController');

    Route::resource('media', 'MediaController');
});





// Route::middleware('auth:api')->resource('test', 'ExampleController');


