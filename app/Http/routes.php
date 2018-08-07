<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('/{database}/course_type', 'CourseController@showCourseType');
Route::get('/{database}/clients/{cpf}', 'ClientController@search');

Route::get('/{database}/course_area', 'CourseController@showCourseArea');
Route::get('/{database}/course/{courseType}/{courseArea}', 'CourseController@showCourse');
Route::get('/{database}/search_media', 'SearchMediaController@showMedia');
Route::get('/{database}/pagamment_plane/{cdcurso}', 'PagammentPlaneController@showPlane');
Route::get('/{database}/pagamment_month/{month}', 'PagammentPlaneController@startMonth');
Route::get('/{database}/material_plane/{cdcurso}', 'MaterialPlaneController@showPlane');
Route::get('/{database}/enrolment_plane/{cdcurso}', 'EnrolmentPlaneController@showPlane');
Route::get('/{database}/enrolment_date/{days}', 'EnrolmentPlaneController@getDateVenc');

Route::get('/{database}/state', 'LocationController@getState');
Route::get('/{database}/city/{cdestado}', 'LocationController@getCity');
Route::get('/{database}/graduation', 'GraduationController@showGraduation');
Route::get('/{database}/contract', 'ContractController@getContract');
Route::get('/{database}/codecitystate/{namecity}', 'LocationController@getNameCityState');
Route::get('/{database}/document/{type}', 'DocumentController@getDocument');

Route::get('/{database}/student/{cpf}/{cdcourse}', 'ClientController@student');
Route::get('/{database}/verifydtcolacao/{date}/{typeCourse}', 'ClientController@verifyDtColacao');

Route::get('/{database}/citystatename/{cdcidade}', 'LocationController@getName');
Route::get('/{database}/search_media/{cdmidia}', 'SearchMediaController@getMedia');
Route::get('/{database}/search_course/{cdcurso}', 'CourseController@getCourse');
Route::get('/{database}/graduation/{cdformacao}', 'GraduationController@getGraduation');

Route::post('/{database}/enrolment', 'EnrolmentController@save');

Route::get('/{database}/discipline/{cdcurso}', 'CourseDisciplineController@getDiscipline');

Route::group(['middleware' => 'oauth'], function () {


});


