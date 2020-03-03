<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/intro', function () {
    return view('intro');
});

Route::get('test', function () {
	return view('test.index');
});

Route::get('map', function () {
	return view('test.index');
});
Route::post('compare', 'ScenarioController@compare');

Route::get('json', function () {
	return view('test.mapboxjson');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');