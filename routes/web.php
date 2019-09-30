<?php

Auth::routes();
Route::view('/','welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

// DATA
Route::get('/get-documents', 'DocumentController@getall');
Route::get('/get-types', 'TypeController@getall');
Route::post('/check-document', 'DocumentController@check_document');
// FIN DATA

// USUARIOS
Route::get('/users', 'UsersController@index')->name('users.index');
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

});
// FIN PRECARGA

// PROFESORES
Route::get('/profesores','TeacherController@index')->name('teacher.index');
Route::post('/get-teachers','TeacherController@teacherDataTable');
Route::post('/store-teacher','TeacherController@store');
Route::post('/update-teacher','TeacherController@update');
Route::post('/delete-teacher','TeacherController@destroy');
// FIN PROFESORES