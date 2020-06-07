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
	Route::get('/LoginPage','LoginSchoolController@IndexLogin');
	
	Route::post('/Login','LoginSchoolController@LoginSchool');
	
	// Route::get('/register','LoginSchoolController@RegisterSchool');

	Route::get('/logout','LoginSchoolController@LogoutSchool');

// Route::post('/register','LoginSchoolController@RegisterSchool');




});

Route::prefix('kelas')->group(function()
{
	Route::get('/','KelasController@IndexGetClass');
	Route::get('//','KelasController@tambahKelas');
	Route::post('/','KelasController@storeKelas');
	Route::get('//edit/{id}','KelasController@editKelas');
	Route::put('//update/{id}','KelasController@updateKelas');
	Route::get('///{}','KelasController@deleteKelas');




});

// Route::prefix('student')->group(function(){
// 	Route::get('/LoginStudent','StudentController@IndexLoginStudent');
// 	// Route::get('/StudentLoginPage','StudentController@LoginStudent');
// 	// Route::get('/LoginPageStudent','StudentController@RegisterStudent');

// 	// Route::post('/StudentLoginPage','StudentController@LoginStudent');
// 	Route::post('/LoginStudent','StudentController@RegisterStudent')->name('siswa.store');


// 	// Route::get('/StudentLogout','StudentController@LogoutStudent');


// });

Route::prefix('raport')->group(function(){
	Route::get('/', 'RaportController@IndexGetRaport');
	Route::get('/{type}','RaportController@DownloadDataNilai');
	Route::post('//importUts','RaportController@importNilai');
});

Route::get('/Dashboard','DashboardController@IndexDashboard');

// Route::get('/', function () {
//     return redirect('/student/LoginStudent');
// });

Route::get('/', function () {
	return redirect('/auth/LoginPage');
});
