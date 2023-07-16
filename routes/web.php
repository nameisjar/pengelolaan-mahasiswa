<?php

use App\Http\Controllers\AdminController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/dashboard', [AdminController::class, 'show'])->name('dashboard');
    Route::post('/dataMahasiswa', [AdminController::class, 'store'])->name('storeMahasiswa');
    Route::get('/deleteMahasiswa/{id}', [AdminController::class, 'destroy'])->name('deleteMahasiswa');
    Route::get('/editMahasiswa/{id}', [AdminController::class, 'edit'])->name('editMahasiswa');
    Route::patch('/updateMahasiswa/{id}', [AdminController::class, 'update'])->name('updateMahasiswa');
    route::get('/inputNilai/{mahasiswa}', [AdminController::class, 'show2'])->name('inputNilai');
    Route::post('/inputData/{id}', [AdminController::class, 'store2'])->name('inputData');
    Route::get('/deleteNilai/{id}', [AdminController::class, 'destroy2'])->name('deleteNilai');
    route::patch('/updateFoto', [AdminController::class, 'updateAdmin'])->name('updateFoto');
});

route::group(['middleware' => ['guest:admin']], function () {
    route::get('/', [AdminController::class, 'index'])->name('signin');
    route::post('/signin', [AdminController::class, 'login'])->name('signin.post');
});

