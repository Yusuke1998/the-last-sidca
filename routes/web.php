<?php

Auth::routes();

Route::view('/','welcome');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Auth::routes();

Route::get('/users', 'UsersController@index')->name('users.index');
Route::post('/get-users','UsersController@userDataTable')->name('users.datatable');
Route::post('/store-user','UsersController@store')->name('users.store');
Route::post('/update-user','UsersController@update')->name('users.update');
Route::post('/delete-user','UsersController@destroy')->name('users.destroy');