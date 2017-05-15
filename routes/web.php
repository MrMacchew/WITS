<?php

Route::get('/', function () {
    return view('welcome');

});


Route::group(array('prefix' => 'api/v1', 'middleware' => []), function () {
    // Custom route added to standard Resource
    // Route::get('example/foo', 'ExampleController@foo');
    // Standard Resource route
    // Route::resource('example', 'ExampleController');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@login'] )->middleware('saml');
Route::get('/logout', [ 'as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('/saml-response', 'Auth\LoginController@saml');


Route::resource('assets', 'Api\v1\AssetController');
Route::resource('rooms', 'Api\v1\RoomController');

Route::get('dashboard', 'DashboardController@index');

// Route::get('inventory', 'PagesController@inventory');
// Route::get('settings', 'PagesController@settings');


Route::group(['middleware' => 'auth'], function () {
	Route::get('inventory', 'PagesController@inventory');
	Route::get('departments', 'PagesController@departments');
	Route::get('settings', 'PagesController@settings');
	Route::get('locations', 'PagesController@locations');

	Route::get('users', 'PagesController@users');
	Route::get('users/roles-permissions', 'PagesController@rolesPermissions');

	Route::get('reports', 'PagesController@reports');
});


Route::get('/install', function(){
	Artisan::call('db:make');

	echo 'DB Migration, DONE... ';
	sleep(2);
    return redirect('/');
});
