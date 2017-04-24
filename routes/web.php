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

Route::resource('assets', 'Api\v1\AssetController');
Route::resource('room', 'Api\v1\RoomController');

Route::get('dashboard', 'DashboardController@index');

Route::get('/install', function(){
	Artisan::call('db:make');

	echo 'DB Migration, DONE... ';
	sleep(2);
    return redirect('/');
});
