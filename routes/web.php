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
  Route::get('home', function () {
    return view('content.home');
  });
  
  Route::get('/news/{page?}', 'NewsController@index')->name('news list');
  Route::post('/news/input', 'NewsController@store')->name('entry new news');
  Route::delete('/news/{id}', 'NewsController@delete')->name('delete news');

  Route::get('/mahasiswa', 'MahasiswaController@index')->name('list all students');
  Route::get('/mahasiswa/up-grades', 'MahasiswaController@upgrades')->name('naik semester');
  Route::get('/mahasiswa/down-grades', 'MahasiswaController@downgrades')->name('turun semester');
  Route::post('/mahasiswa/input', 'MahasiswaController@input')->name('entry calon mahasiswa');
  Route::post('/mahasiswa/edit', 'MahasiswaController@edit')->name('edit mahasiswa');
  Route::get('/mahasiswa-pdf', 'MahasiswaController@downloadPdf')->name('download students list');
  Route::get('/mahasiswa/datatable', 'MahasiswaController@datatable')->name('ajax datatable');
  Route::delete('/mahasiswa/{id}', 'MahasiswaController@delete')->name('delete mahasiswa');
  
  Route::get('/nilai', 'NilaiController@index')->name('list of students score');
  Route::post('/nilai', 'NilaiController@edit')->name('edit score');
  Route::get('/nilai-pdf', 'NilaiController@downloadPdf')->name('download students score');

  Route::get('/input-nilai/{page?}', 'InputNilaiController@index')->name('show view');
  Route::post('/input-nilai', 'InputNilaiController@store')->name('entry students score');

  Route::get('/remidial', 'RemidialController@index')->name('list remedial');
  Route::get('/remidial/edit', 'RemidialController@edit')->name('edit remedial score');
  Route::get('/remidial-pdf', 'RemidialController@downloadPdf')->name('download remedial score');

  Route::get('/tampilschedule', 'HitungIpsController@index')->name('validasi hitung IPS');
  Route::get('/hitungip/{semester}/{jurusan}', 'HitungIpsController@hitung')->name('tampilkan IPS');
  Route::post('/action-ips', 'HitungIpsController@actionController')->name('entry IPS');
  Route::get('/ajax/{nim}', 'HitungIpsController@ajax')->name('preview detail IPS');

  Route::get('validasi', 'HitungIpkController@index')->name('validasi hitung IPK');
  Route::get('hitungipk/{semester}', 'HitungIpkController@hitung')->name('hitung IPK');
  Route::post('/action-ipk', 'HitungIpkController@actionController')->name('entry IPK');

  Route::get('/timeline', 'TimelineController@index')->name('index');
});