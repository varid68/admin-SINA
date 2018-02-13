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

Route::middleware('key')->group(function() {
  Route::get('/home', 'HomeController@index')->name('home');
  
  Route::get('/news/{page?}', 'NewsController@index')->name('news list');
  Route::post('/news/input', 'NewsController@store')->name('input new news');
  Route::delete('/news/{id}', 'NewsController@delete')->name('delete news');

  Route::get('/mahasiswa', 'MahasiswaController@index')->name('list all students');
  Route::get('/mahasiswa-pdf', 'MahasiswaController@downloadPdf')->name('download students list');
  Route::get('/mahasiswa/datatable', 'MahasiswaController@datatable')->name('ajax datatable');
  
  Route::get('/alumni/{page?}', 'AlumniController@index')->name('list all alumni');
  Route::get('/alumni-pdf', 'AlumniController@downloadPdf')->name('download alumni list');
  Route::post('/alumni', 'AlumniController@store')->name('update alumni');
  
  Route::get('/nilai', 'NilaiController@index')->name('list of students score');
  Route::get('/nilai-pdf', 'NilaiController@downloadPdf')->name('download students score');

  Route::get('/input-nilai/{page?}', 'InputNilaiController@index')->name('show view');
  Route::post('/input-nilai', 'InputNilaiController@store')->name('insert students score');

  Route::get('/remidial', 'RemidialController@index')->name('list remedial');
  Route::get('/remidial/edit', 'RemidialController@edit')->name('edit remedial score');
  Route::get('/remidial-pdf', 'RemidialController@downloadPdf')->name('download remedial score');
  
});