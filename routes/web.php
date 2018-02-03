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
  return view('login');
});

Route::post('/login', 'LoginController@index')->name('login');
Route::get('/login/{id}', 'LoginController@setSession')->name('set-sesi');
Route::get('/logout', 'LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home')->middleware('key');

Route::get('/point', 'PointController@index')->name('point')->middleware('key');

Route::get('/nilai/{page?}', 'NilaiController@index')->middleware('key');
Route::post('/nilai', 'NilaiController@store')->middleware('key');

Route::get('/mahasiswa', 'MahasiswaController@index')->middleware('key');
Route::get('/mahasiswa-pdf', 'MahasiswaController@downloadPdf')->middleware('key');
Route::get('/mahasiswa/datatable', 'MahasiswaController@datatable')->middleware('key');

Route::get('/alumni/{page?}', 'AlumniController@index')->middleware('key');
Route::get('/alumni-pdf', 'AlumniController@downloadPdf')->middleware('key');

Route::get('/remidial', 'RemidialController@index')->middleware('key');

Route::get('/news/{page?}', 'NewsController@index')->middleware('key');
Route::post('/news/input', 'NewsController@store')->middleware('key');
Route::delete('/news/{id}', 'NewsController@delete')->middleware('key');