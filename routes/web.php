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

Auth::routes(['register' => false]);

Route::post('/scan', 'GreenController@scan');
Route::post('/check/url', 'GreenController@url_exists');
Route::get('/progress', 'GreenController@getProgess');


Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
	Route::get('/', 'AdminController@index');
});
/*
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
	Route::get('/', 'AdminController@index');
});
*/


Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');

/*



Route::get('/', 'GreenController@index');
Route::get('/scan', 'GreenController@scan');
Route::get('/progress', 'GreenController@getProgess');


Route::get('/conseils', function() {
	return view('conseils');
});


Route::get('/home', 'HomeController@index')->name('home');
*/