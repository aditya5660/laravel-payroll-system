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

Auth::routes();
/* CoreUI templates */

Route::middleware('auth')->group(function() {
    Route::view('/', 'panel.blank');
    Route::resource('ajaxproducts','ProductAjaxController');
    Route::resource('absensi', 'AbsensiController');
    Route::get('absensi/{id}', 'AbsensiController@list')->name('absensi.list');
    Route::post('rekap-absensi', 'AbsensiController@rekap')->name('absensi.rekap');
    Route::post('slip-gaji', 'GajiController@slip')->name('gaji.slip-gaji');
    Route::resource('jabatan', 'JabatanController');
    Route::resource('jenis-tunjangan', 'JenisTunjanganController');
    Route::resource('karyawan', 'KaryawanController');
    Route::resource('tunjangan-jabatan', 'TunjanganJabatanController');
    Route::resource('gaji','GajiController');
    Route::resource('users','UsersController');

	Route::view('/sample/dashboard','samples.dashboard');
	Route::view('/sample/buttons','samples.buttons');
	Route::view('/sample/social','samples.social');
	Route::view('/sample/cards','samples.cards');
	Route::view('/sample/forms','samples.forms');
	Route::view('/sample/modals','samples.modals');
	Route::view('/sample/switches','samples.switches');
	Route::view('/sample/tables','samples.tables');
	Route::view('/sample/tabs','samples.tabs');
	Route::view('/sample/icons-font-awesome', 'samples.font-awesome-icons');
	Route::view('/sample/icons-simple-line', 'samples.simple-line-icons');
	Route::view('/sample/widgets','samples.widgets');
	Route::view('/sample/charts','samples.charts');
});
// Section Pages
Route::view('/sample/error404','errors.404')->name('error404');
Route::view('/sample/error500','errors.500')->name('error500');
