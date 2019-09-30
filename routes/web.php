<?php

Auth::routes();
Route::view('/','welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

// DATA
Route::get('/get-documents', 'DocumentController@getAll');
Route::get('/get-headquarters', 'HeadquarterController@getAll');
Route::get('/get-cores', 'CoreController@getAll');
Route::get('/get-areas', 'AreaController@getAll');
Route::get('/get-types', 'TypeController@getAll');
Route::post('/check-document', 'DocumentController@check_document');
// FIN DATA

// USUARIOS
Route::get('/usuarios', 'UsersController@index')->name('users.index');
Route::post('/get-users','UsersController@userDataTable');
Route::post('/store-user','UsersController@store');
Route::post('/update-user','UsersController@update');
Route::post('/delete-user','UsersController@destroy');
Route::get('/profile-user/{username?}','UsersController@profile')->name('profile');
// FIN USUARIOS

// PRECARGA DE DATOS
Route::group(['prefix'=>'precarga'],function(){
	
	// SEDES
	Route::get('/sedes','HeadquarterController@index')->name('headquarter.index');
	Route::post('/get-headquarters','HeadquarterController@headquarterDataTable');
	Route::post('/store-headquarter','HeadquarterController@store');
	Route::post('/update-headquarter','HeadquarterController@update');
	Route::post('/delete-headquarter','HeadquarterController@destroy');
	// FIN SEDES
	
	// NUCLEOS
	Route::get('/nucleos','CoreController@index')->name('core.index');
	Route::post('/get-cores','CoreController@coreDataTable');
	Route::post('/store-core','CoreController@store');
	Route::post('/update-core','CoreController@update');
	Route::post('/delete-core','CoreController@destroy');
	// FIN NUCLEOS

	// AREAS
	Route::get('/areas','AreaController@index')->name('area.index');
	Route::post('/get-areas','AreaController@areaDataTable');
	Route::post('/store-area','AreaController@store');
	Route::post('/update-area','AreaController@update');
	Route::post('/delete-area','AreaController@destroy');
	// FIN AREAS

	// AREAS
	Route::get('/carreras','CareerController@index')->name('career.index');
	Route::post('/get-careers','CareerController@careerDataTable');
	Route::post('/store-career','CareerController@store');
	Route::post('/update-career','CareerController@update');
	Route::post('/delete-career','CareerController@destroy');
	// FIN AREAS

});
// FIN PRECARGA

// PROFESORES
Route::get('/profesores','TeacherController@index')->name('teacher.index');
Route::post('/get-teachers','TeacherController@teacherDataTable');
Route::post('/store-teacher','TeacherController@store');
Route::post('/update-teacher','TeacherController@update');
Route::post('/delete-teacher','TeacherController@destroy');
// FIN PROFESORES