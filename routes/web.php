<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('roles')->group(function(){
	Route::get('/','KelasController@IndexGetRoles');
	// Route::get('//','KelasController@tambahKelas');
	Route::post('/','KelasController@storeRoles');
	Route::get('//edit/{id}','KelasController@editRoles');
	Route::put('//update/{id}','KelasController@updateRoles');
	Route::get('///{}','KelasController@deleteRoles');


});

Route::prefix('auth')->group(function(){
	Route::get('/LoginPage','SchoolInternalController@IndexLogin');
	
	Route::post('/Login','SchoolInternalController@LoginSchool');
	
	

	Route::get('/logout','SchoolInternalController@LogoutSchool');

	Route::get('/internal/inputGuru','SchoolInternalController@IndexGetGuru');

	Route::post('/internal/inputGuru','SchoolInternalController@storeGuru');

	Route::get('/internal/EditDataWalikelas/edit/{id}','SchoolInternalController@editWalikelas');

	

	Route::put('/internal/update/{id}','SchoolInternalController@updateWalikelas');

	Route::get('internal/inputGuru/hapus/{id}','SchoolInternalController@deleteGuru');

	Route::get('/internal/DaftarNilaiSiswa/{id}','mata_pelajaranController@exportNilai');

	
});


Route::prefix('kelas')->group(function()
{
	Route::get('/','KelasController@IndexGetClass');
	Route::get('//','KelasController@tambahKelas');
	Route::post('/','KelasController@storeKelas');
	Route::get('//edit/{id}','KelasController@editKelas');
	Route::put('//update/{id}','KelasController@updateKelas');
	Route::get('//hapus/{id}','KelasController@deleteKelas');




});

Route::prefix('student')->group(function(){
	Route::get('/LoginStudent','StudentController@IndexLoginStudent');
	Route::post('/StudentLoginPage','StudentController@LoginStudent');


	Route::get('/internal/inputSiswa','StudentController@IndexGetSiswa');

	Route::get('/siswa/DataWaliKelas','StudentController@getDataWalikelas');

	Route::get('/siswa/NilaiSiswa/{id}','StudentController@IndexNilaiSiswa');


	
	
	Route::post('/internal/inputSiswa','StudentController@storeSiswa');

	Route::get('/internal/EditDataSiswa/edit/{id}','StudentController@editSiswa');

	Route::put('/internal/update/{id}','StudentController@updateSiswa');


	Route::get('internal/inputSiswa/hapus/{id}','StudentController@deleteSiswa');

	Route::get('/internal/DataSiswa/{kelas}','StudentController@DataSiswa');


    Route::get('/activate/{email}/{code}','Security\ActivationController@activate');
	Route::get('/StudentLogout','StudentController@LogoutStudent');

	


});

Route::prefix('raport')->group(function(){
	Route::get('/internal/DaftarNilaiKelas10','RaportController@GetTahunAjaran');
	Route::get('//edit/{id}','RaportController@editNilai');
	Route::put('//update/{id}','RaportController@updateNilai');
	Route::get('///','RaportController@deleteNilai');
});

Route::prefix('raportHeader')->group(function(){

	// Route::get('/internal/DaftarNilaiKelas10','mata_pelajaranController@IndexGetMataPelajaran');

});


Route::prefix('pelajaran')->group(function(){

Route::get('/internal/ImportNilai','mata_pelajaranController@IndexImportNilai');

	Route::get('/internal/DaftarNilaiSiswa/{id}','mata_pelajaranController@IndexMataPelajaran');

	Route::post('/internal/DaftarNilaiSiswa/{id}', 'mata_pelajaranController@IndexMataPelajaran');

	Route::post('/internal/DaftarNilaiSiswa','mata_pelajaranController@storeMataPelajaran');
	


});

Route::prefix('password')->group(function(){

	Route::get('/Siswa/ChangePassword','ChangePasswordController@editChangePassword');
	Route::patch('/student/UpdatePassword','ChangePasswordController@update');

});

Route::get('/internal/internal-dashboard','DashboardController@IndexDashboard');
Route::get('/student/student-view','DashboardSiswaController@IndexDashboardSiswa');


Route::post('reset_password_wihout_token',
	'ForgotPasswordController@validatePasswordRequest');
Route::post('reset_password_with_token','ForgotPasswordController@resetPassword');

Route::get('/', function () {
	return redirect('/auth/LoginPage');
});
