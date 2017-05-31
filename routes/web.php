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

Route::get('/browserSync/login/{user}', function($user){
    $user = \App\User::where('username',$user) -> first();
    Auth::login($user, true);
    return redirect('/dashboard');
});



Route::get('/test', function(){
     $buildings = \App\Building::with('BuildDepartRoom.room', 'BuildDepartRoom.department', 'BuildDepartRoom.department.org')->get();
     // $buildings = \App\Building::with('BuildDepartRoom.room', 'BuildDepartRoom.department', 'BuildDepartRoom.department.org');
     $rooms = \App\Room::with('BuildDepartRoom.building', 'BuildDepartRoom.department')->first();
     $departments = \App\Department::with('BuildDepartRoom.building', 'BuildDepartRoom.room')->first();



// $user->teamsRolesUsers->first()->team;
// $user->teamsRolesUsers->first()->role;

     // dump($buildings->toArray());
     // dump($buildings->first()->buildDepartRoom->first()->department->get()->first()->org->first()->code);
     // dump($rooms->toArray());
     // dump($departments->toArray());

     return $buildings;

});



Route::resource('assets', 'Api\v1\AssetController');
Route::resource('rooms', 'Api\v1\RoomController');

Route::get('dashboard', 'DashboardController@index');

// Route::get('inventory', 'PagesController@inventory');
// Route::get('settings', 'PagesController@settings');


Route::group(
	// []
	['middleware' => 'auth']
	, function () {
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
