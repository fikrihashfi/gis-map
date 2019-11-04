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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes([
    'reset' => false,
    'verify' => false,
    'register' => false
]);

Route::get('/', 'MapController@index')->name('map');

Route::get('/gempa/add', 'HomeController@add')->name('gempa.add');

Route::get('/gempa', 'HomeController@index')->name('gempa');

Route::post('/map/add', 'MapController@add')->name('add.data');

Route::post('/map/delete','MapController@delete');

Route::post('/map/edit','MapController@edit');



