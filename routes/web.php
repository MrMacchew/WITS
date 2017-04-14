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
