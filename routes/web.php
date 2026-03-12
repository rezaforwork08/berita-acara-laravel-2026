<?php

use Illuminate\Support\Facades\Route;
use League\Uri\Http;


//get = melihat data atau menampilkannya
//post = mengirim data
//put/patch = merubah atau mengedit data
//delete = menghapus data
Route::get('navbar', function () {
    return view('inc.navbar');
});
//Tampilan form perhitungan
Route::get('perhitungan', function () {
    return view('perhitungan.index');
})->name('perhitungan.index');
//Tampilan form Luas Permukaan Kubus
Route::get('luaspermukaankubus', [App\Http\Controllers\PerhitunganController::class, 'index'])->name('luaspermukaankubus.index');

//Aksi Perhitungannya
Route::post('perhitungan', [App\Http\Controllers\PerhitunganController::class, 'store'])->name('perhitungan.store');
//Aksi Perhitungan LP Kubus
Route::post('luaspermukaankubus', [App\Http\Controllers\PerhitunganController::class, 'storeLpKubus'])->name('luaspermukaankubus.store');



Route::get('volumekubus', [App\Http\Controllers\PerhitunganController::class, 'indexVolKubus'])->name('volumekubus.index');

Route::post('volumekubus', [App\Http\Controllers\PerhitunganController::class, 'storeVolKubus'])->name('volumekubus.store');




// Route::get('volumelimas', [App\Http\Controllers\VolumeLimasController::class, 'index'])->name('volumelimas.index');

// Route::get('volumelimas/create', [App\Http\Controllers\VolumeLimasController::class, 'create'])->name('volumelimas.create');

// Route::post('volumelimas/store', [App\Http\Controllers\VolumeLimasController::class, 'store'])->name('volumelimas.store');

// Route::get('volumelimas/edit/{id}', [App\Http\Controllers\VolumeLimasController::class, 'edit'])->name('volumelimas.edit');

// Route::put('volumelimas/update/{id}', [App\Http\Controllers\VolumeLimasController::class, 'update'])->name('volumelimas.update');

// Route::delete('volumelimas/delete/{id}', [App\Http\Controllers\VolumeLimasController::class, 'destroy'])->name('volumelimas.destroy');
Route::resource('volumelimas', App\Http\Controllers\VolumeLimasController::class);

Route::get('belajar-laravel', [\App\Http\Controllers\BelajarController::class, 'index']);
Route::get('siswa', [\App\Http\Controllers\BelajarController::class, 'getSiswa']);

Route::get('create', [\App\Http\Controllers\BelajarController::class, 'create'])->name('siswa.create');
Route::post('store', [\App\Http\Controllers\BelajarController::class, 'store'])->name('siswa.store');

Route::get('/', [\App\Http\Controllers\LoginController::class, 'index']);
Route::post('action-login', [\App\Http\Controllers\LoginController::class, 'actionLogin'])->name('action-login');
Route::post('logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::resource('user', App\Http\Controllers\UserController::class);
Route::resource('role', App\Http\Controllers\RoleController::class);
Route::resource('student', App\Http\Controllers\StudentController::class);

Route::resource('attendance', App\Http\Controllers\AttendanceController::class);


// get, post, put,delete
Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);

// Route::get('/login', function () {
//     return view('nama-view');
// });
