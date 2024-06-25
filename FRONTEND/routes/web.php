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

Route::post('/dashboard/admin/users', [userController::class, 'usersStore'])->name('admin-users-store');
Route::get('/dashboard/admin/users/{nrp}/edit', [UserController::class, 'usersEdit'])->name('admin-users-edit');
Route::put('/dashboard/admin/users/{nrp}', [UserController::class, 'usersUpdate'])->name('admin-users-update');
Route::delete('/dashboard/admin/users/{nrp}', [userController::class, 'usersDelete'])->name('admin-users-delete');

Route::get('/dashboard/admin/roles', [userController::class, 'rolesIndex'])->name('admin-roles');
Route::get('/dashboard/admin/roles/create', [userController::class, 'rolesCreate'])->name('admin-roles-create');
Route::post('/dashboard/admin/roles', [userController::class, 'rolesStore'])->name('admin-roles-store');
Route::get('/dashboard/admin/roles/{id}/edit', [UserController::class, 'rolesEdit'])->name('admin-roles-edit');
Route::put('/dashboard/admin/roles/{id}', [UserController::class, 'rolesUpdate'])->name('admin-roles-update');
Route::delete('/dashboard/admin/roles/{id}', [userController::class, 'rolesDelete'])->name('admin-roles-delete');

Route::get('/dashboard/admin/fakultas', [userController::class, 'fakultasIndex'])->name('admin-fakultas');
Route::get('/dashboard/admin/fakultas/create', [userController::class, 'fakultasCreate'])->name('admin-fakultas-create');
Route::post('/dashboard/admin/fakultas', [userController::class, 'fakultasStore'])->name('admin-fakultas-store');
Route::get('/dashboard/admin/fakultas/{kode}/edit', [UserController::class, 'fakultasEdit'])->name('admin-fakultas-edit');
Route::put('/dashboard/admin/fakultas/{kode}', [UserController::class, 'fakultasUpdate'])->name('admin-fakultas-update');
Route::delete('/dashboard/admin/fakultas/{kode}', [userController::class, 'fakultasDelete'])->name('admin-fakultas-delete');

Route::get('/dashboard/admin/prodi', [userController::class, 'prodiIndex'])->name('admin-prodi');
Route::get('/dashboard/admin/prodi/create', [userController::class, 'prodiCreate'])->name('admin-prodi-create');
Route::post('/dashboard/admin/prodi', [userController::class, 'prodiStore'])->name('admin-prodi-store');
Route::get('/dashboard/admin/prodi/{kode}/edit', [UserController::class, 'prodiEdit'])->name('admin-prodi-edit');
Route::put('/dashboard/admin/prodi/{kode}', [UserController::class, 'prodiUpdate'])->name('admin-prodi-update');
Route::delete('/dashboard/admin/prodi/{kode}', [userController::class, 'prodiDelete'])->name('admin-prodi-delete');

Route::get('/dashboard/admin/beasiswa', [userController::class, 'beasiswaIndex'])->name('admin-beasiswa');
Route::get('/dashboard/admin/beasiswa/create', [userController::class, 'beasiswaCreate'])->name('admin-beasiswa-create');
Route::post('/dashboard/admin/beasiswa', [userController::class, 'beasiswaStore'])->name('admin-beasiswa-store');
Route::get('/dashboard/admin/beasiswa/{id}/edit', [UserController::class, 'beasiswaEdit'])->name('admin-beasiswa-edit');
Route::put('/dashboard/admin/beasiswa/{id}', [UserController::class, 'beasiswaUpdate'])->name('admin-beasiswa-update');
Route::delete('/dashboard/admin/beasiswa/{id}', [userController::class, 'beasiswaDelete'])->name('admin-beasiswa-delete');

Route::get('/dashboard/admin/periode', [userController::class, 'periodeIndex'])->name('admin-periode');
Route::get('/dashboard/admin/periode/create', [userController::class, 'periodeCreate'])->name('admin-periode-create');
Route::post('/dashboard/admin/periode', [userController::class, 'periodeStore'])->name('admin-periode-store');
Route::get('/dashboard/admin/periode/{id}/edit', [UserController::class, 'periodeEdit'])->name('admin-periode-edit');
Route::put('/dashboard/admin/periode/{id}', [UserController::class, 'periodeUpdate'])->name('admin-periode-update');
Route::delete('/dashboard/admin/periode/{id}', [userController::class, 'periodeDelete'])->name('admin-periode-delete');

