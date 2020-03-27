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

Route::post('/scan', 'GreenController@scan');
Route::post('/check/url', 'GreenController@url_exists');
Route::get('/progress', 'GreenController@getProgess');

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');

/*
Auth::routes();


Route::get('/', 'GreenController@index');
Route::get('/scan', 'GreenController@scan');
Route::get('/progress', 'GreenController@getProgess');


Route::get('/conseils', function() {
	return view('conseils');
});


Route::get('/home', 'HomeController@index')->name('home');
*/