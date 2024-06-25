<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\userController;

Route::get('login', [loginController::class, 'index'])->name('login');
Route::post('login', [loginController::class, 'login'])->name('login.post');
Route::get('logout', [loginController::class, 'logout'])->name('logout');

// Route::group(['middleware' => ['verify.jwt']], function () {
//     Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/', [dashboardController::class, 'index'])->name('home')->middleware('role:1,2,3');
// });

Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/admin/users', [userController::class, 'usersIndex'])->name('admin-users');
Route::get('/dashboard/admin/users/create', [userController::class, 'usersCreate'])->name('admin-users-create');
Route::post('/dashboard/admin/users/{nrp}', [userController::class, 'showEditForm'])->name('admin-users-edit');
Route::delete('/dashboard/admin/users/{nrp}', [userController::class, 'userDelete'])->name('admin-users-delete');
Route::post('/dashboard/admin/users', [userController::class, 'usersStore'])->name('admin-users-store');
Route::get('/dashboard/admin/fakultas', [userController::class, 'fakultasIndex'])->name('admin-fakultas');
Route::get('/dashboard/admin/prodi', [userController::class, 'prodiIndex'])->name('admin-prodi');
Route::get('/dashboard/admin/beasiswa', [userController::class, 'prodiIndex'])->name('admin-beasiswa');