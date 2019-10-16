<?php

Auth::routes();
Route::view('/','welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

// DATA
Route::get('/get-pre-teacher/{teacher}', 'UndergraduateController@getAll');
Route::get('/get-post-teacher/{teacher}', 'PostgraduateController@getAll');
Route::get('/get-teachers','TeacherController@getAll');
Route::get('/get-teacher/{dni?}','TeacherController@search');
Route::get('/get-headquarters', 'HeadquarterController@getAll');
Route::get('/get-programs', 'ProgramController@getAll');
Route::get('/get-subjects', 'SubjectController@getAll');
Route::get('/get-cores', 'CoreController@getAll');
Route::get('/get-documents', 'DocumentController@getAll');
Route::get('/get-titles', 'TitleController@getAll');
Route::get('/get-universities', 'UniversityController@getAll');
Route::get('/get-periods', 'PeriodController@getAll');
Route::get('/get-types', 'TypeController@getAll');
Route::get('/get-conditions', 'ConditionController@getAll');
Route::get('/get-categories', 'CategoryController@getAll');
Route::get('/get-dedications', 'DedicationController@getAll');

Route::post('/check-document', 'DocumentController@check_document');
// FIN DATA

// PRECARGA DE DATOS
Route::group(['prefix'=>'precarga','middleware'=>'auth'],function(){
	
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

	// EXTENSIONES
	Route::get('/extensiones','ExtensionController@index')->name('extension.index');
	Route::post('/get-extensions','ExtensionController@extensionDataTable');
	Route::post('/store-extension','ExtensionController@store');
	Route::post('/update-extension','ExtensionController@update');
	Route::post('/delete-extension','ExtensionController@destroy');
	// FIN EXTENSIONES

	// AULAS TERRITORIALES
	Route::get('/aulas-territoriales','TerritorialClassroomController@index')->name('tclassroom.index');
	Route::post('/get-tclassrooms','TerritorialClassroomController@tclassroomDataTable');
	Route::post('/store-tclassroom','TerritorialClassroomController@store');
	Route::post('/update-tclassroom','TerritorialClassroomController@update');
	Route::post('/delete-tclassroom','TerritorialClassroomController@destroy');
	// FIN AULAS TERRITORIALES

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

	// AUTORIDADES
	Route::get('/autoridades','AuthorityController@index')->name('authority.index');
	Route::post('/get-authorities','AuthorityController@authorityDataTable');
	Route::post('/store-authority','AuthorityController@store');
	Route::post('/update-authority','AuthorityController@update');
	Route::post('/delete-authority','AuthorityController@destroy');
	// FIN AUTORIDADES

});
// FIN PRECARGA

// USUARIOS
Route::get('/usuarios', 'UsersController@index')
	->name('users.index')
	->middleware('auth');
Route::post('/get-users','UsersController@userDataTable');
Route::post('/store-user','UsersController@store');
Route::post('/update-user','UsersController@update');
Route::post('/delete-user','UsersController@destroy');
Route::get('/profile-user/{username?}','UsersController@profile')->name('profile');
// FIN USUARIOS

// PROFESORES
Route::get('/profesores/ordinarios','TeacherController@ordinary')
	->name('ordinary.index')
	->middleware('auth');

Route::get('/profesores/contratados','TeacherController@hired')
	->name('hired.index')
	->middleware('auth');

Route::post('/get-teachers','TeacherController@teacherDataTable');
Route::post('/store-teacher','TeacherController@store');
Route::post('/update-teacher','TeacherController@update');
Route::post('/delete-teacher','TeacherController@destroy');

Route::post('/save-preG-title','TeacherController@savePreG');
Route::post('/save-postG-title','TeacherController@savePostG');

Route::get('/profesores/historico/{dni?}','TeacherController@history')->name('teacher.history');
// FIN PROFESORES

// NOTIFICACIONES
Route::get('/notificaciones','HomeController@notifications')
	->name('notifications.index')
	->middleware('auth');
// FIN NOTIFICACIONES