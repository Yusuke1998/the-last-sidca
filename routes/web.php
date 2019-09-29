<?php

Auth::routes();
Route::view('/','welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

// DATA
Route::get('/get-documents', 'DocumentController@getall');
Route::get('/get-types', 'TypeController@getall');
// FIN DATA

// USUARIOS
Route::get('/users', 'UsersController@index')->name('users.index');
Route::post('/get-users','UsersController@userDataTable');
Route::post('/store-user','UsersController@store');
Route::post('/update-user','UsersController@update');
Route::post('/delete-user','UsersController@destroy');
Route::get('/profile-user/{username?}','UsersController@profile')->name('profile');
// FIN USUARIOS