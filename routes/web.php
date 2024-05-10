<?php

use App\Models\Posts;
use App\Http\Controllers\DataGejala;
use App\Http\Controllers\DataUser;
use App\Http\Controllers\Penyakit;
use App\Http\Controllers\AuthAdmin;
use App\Http\Controllers\AuthUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardUser;
use App\Http\Controllers\DashboardAdmin;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
Route::get('/', function() {
    return view('layouts_home.welcome', [
        'posts' => Posts::all(),
        'pageTitle' => 'Home'
    ]);
})->name('home');

// Admin
Route::get('/admin/login', [AuthAdmin::class, 'index'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [AuthAdmin::class, 'authenticate'])->name('admin.auth');
Route::post('/admin/logout', [AuthAdmin::class, 'logout'])->name('admin.logout');
Route::middleware('auth:admin')->group(function () {
    Route::get('admin/dashboard', [DashboardAdmin::class, 'index'])->name('admin.dashboard');
    Route::resource('admin/dashboard/gejala', DataGejala::class);
    Route::resource('admin/dashboard/penyakit', Penyakit::class);
    Route::resource('admin/dashboard/datauser', DataUser::class);
    Route::resource('admin/dashboard/posts', DataUser::class);
});

// User
Route::get('/user/register', [AuthUser::class, 'register'])->name('user.register');
Route::post('/user/register', [AuthUser::class, 'store'])->name('user.store');
Route::get('/user/login', [AuthUser::class, 'index'])->name('user.login');
Route::post('/user/login', [AuthUser::class, 'authenticate'])->name('user.auth');
Route::post('/user/logout', [AuthUser::class, 'logout'])->name('user.logout');

Route::middleware('auth:users')->group(function () {
    Route::get('user/dashboard', [DashboardUser::class, 'index'])->name('user.dashboard');
});


