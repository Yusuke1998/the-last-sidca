<?php

Auth::routes();
Route::view('/','welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

// DATA
Route::get('/get-documents', 'DocumentController@getAll');
Route::get('/get-headquarters', 'HeadquarterController@getAll');
Route::get('/get-cores', 'CoreController@getAll');
Route::get('/get-titles', 'TitleController@getAll');
Route::get('/get-universities', 'UniversityController@getAll');
Route::get('/get-subjects', 'SubjectController@getAll');
Route::get('/get-careers', 'CareerController@getAll');
Route::get('/get-areas', 'AreaController@getAll');
Route::get('/get-periods', 'PeriodController@getAll');
Route::get('/get-programs', 'ProgramController@getAll');
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
	
	// UNIVERSIDADES
	Route::get('/universidades','UniversityController@index')->name('university.index');
	Route::post('/get-universities','UniversityController@universitiesDataTable');
	Route::post('/store-university','UniversityController@store');
	Route::post('/update-university','UniversityController@update');
	Route::post('/delete-university','UniversityController@destroy');
	// FIN UNIVERSIDADES
	
	// TITULOS
	Route::get('/titulos','TitleController@index')->name('title.index');
	Route::post('/get-titles','TitleController@titlesDataTable');
	Route::post('/store-title','TitleController@store');
	Route::post('/update-title','TitleController@update');
	Route::post('/delete-title','TitleController@destroy');
	// FIN TITULOS

	// PERIODOS
	Route::get('/periodos','PeriodController@index')->name('period.index');
	Route::post('/get-periods','PeriodController@periodsDataTable');
	Route::post('/store-period','PeriodController@store');
	Route::post('/update-period','PeriodController@update');
	Route::post('/delete-period','PeriodController@destroy');
	// FIN PERIODOS

	// SEDES
	Route::get('/sedes','HeadquarterController@index')->name('headquarter.index');
	Route::post('/get-headquarters','HeadquarterController@headquarterDataTable');
	Route::post('/store-headquarter','HeadquarterController@store');
	Route::post('/update-headquarter','HeadquarterController@update');
	Route::post('/delete-headquarter','HeadquarterController@destroy');
	// FIN SEDES
	
	// AREAS
	Route::get('/areas','AreaController@index')->name('area.index');
	Route::post('/get-areas','AreaController@areaDataTable');
	Route::post('/store-area','AreaController@store');
	Route::post('/update-area','AreaController@update');
	Route::post('/delete-area','AreaController@destroy');
	// FIN AREAS

	// NUCLEOS
	Route::get('/nucleos','CoreController@index')->name('core.index');
	Route::post('/get-cores','CoreController@coreDataTable');
	Route::post('/store-core','CoreController@store');
	Route::post('/update-core','CoreController@update');
	Route::post('/delete-core','CoreController@destroy');
	// FIN NUCLEOS

	// CARRERAS
	Route::get('/carreras','CareerController@index')->name('career.index');
	Route::post('/get-careers','CareerController@careerDataTable');
	Route::post('/store-career','CareerController@store');
	Route::post('/update-career','CareerController@update');
	Route::post('/delete-career','CareerController@destroy');
	// FIN CARRERAS

	// PROGRAMAS
	Route::get('/programas','ProgramController@index')->name('program.index');
	Route::post('/get-programs','ProgramController@programDataTable');
	Route::post('/store-program','ProgramController@store');
	Route::post('/update-program','ProgramController@update');
	Route::post('/delete-program','ProgramController@destroy');
	// FIN PROGRAMAS

	// ASIGNATURAS
	Route::get('/asignaturas','SubjectController@index')->name('subject.index');
	Route::post('/get-subjects','SubjectController@subjectDataTable');
	Route::post('/store-subject','SubjectController@store');
	Route::post('/update-subject','SubjectController@update');
	Route::post('/delete-subject','SubjectController@destroy');
	// FIN ASIGNATURAS

});
// FIN PRECARGA

// PROFESORES
Route::get('/profesores','TeacherController@index')->name('teacher.index');
Route::post('/get-teachers','TeacherController@teacherDataTable');
Route::post('/store-teacher','TeacherController@store');
Route::post('/update-teacher','TeacherController@update');
Route::post('/delete-teacher','TeacherController@destroy');
// FIN PROFESORES