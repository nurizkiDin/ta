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
use Illuminate\Support\Facades\Route;

//masuk
Route::get('/masuk', 'Utama@masuk');
Route::get('/daftar', 'Utama@daftar');
Route::post('/daftar/baru', 'Utama@userBaru');
Route::post('/user', 'Utama@keUser');
Route::get('/', 'Utama@inputData');
Route::get('/edit_user', 'Utama@edit');
Route::post('/edit_user/edit', 'Utama@editUser');
Route::get('/keluar', 'Utama@keluar');
//user
Route::post('/data', 'Diagnosis@dataVariabel');
Route::get('/edit', 'Diagnosis@edit');
Route::post('/edit/data', 'Diagnosis@editData');
Route::get('/hasil', 'Diagnosis@hasil');
//lab
Route::get('/masukLab', 'Dokter@masukLab');
Route::post('/masukLab/dok', 'Dokter@keLab');
Route::get('/lab', 'Dokter@labDok');
Route::post('/lab/data', 'Dokter@dataUji');
Route::get('/lab/edit', 'Dokter@editLab');
Route::post('/lab/edit/data', 'Dokter@editUji');
Route::post('/lab/edit/hapus', 'Dokter@hapusUji');
Route::get('/lab/hasil', 'Dokter@hasilLab');
Route::get('/lab/keluarLab', 'Dokter@keluar');
