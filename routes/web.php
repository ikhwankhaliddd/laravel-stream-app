<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Member\RegisterController;
use App\Http\Controllers\Member\LoginController as MemberLoginController;
use \App\Http\Controllers\Member\DashboardController;

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.login.auth');

Route::group(['prefix' => 'admin', 'middleware' => ['admin.auth']], function (){
    Route::view('/', 'admin.dashboard') -> name('admin.dashboard');

    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

    Route::get('transaction',[TransactionController::class, 'index'])->name('admin.transactions');

    Route::group(['prefix' => 'movie'], function (){
        Route::get('/', [MovieController::class, 'index'])->name('admin.movie');
        Route::get('/create', [MovieController::class, 'create'])->name('admin.movie.create');
        Route::post('/store', [MovieController::class, 'store'])->name('admin.movie.store');
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('admin.movie.edit');
        Route::put('/update/{id}',[MovieController::class, 'update'])->name('admin.movie.update');
        Route::delete('/delete/{id}',[MovieController::class, 'destroy'])->name('admin.movie.destroy');
    });
});

Route::view("/", 'index');
Route::get("/register", [RegisterController::class, 'index'])->name('member.register');
Route::post("/register", [RegisterController::class, 'store'])->name('member.register.store');
Route::get("/login",[MemberLoginController::class, 'index'])->name('member.login');
Route::post("/login",[MemberLoginController::class, 'auth'])->name('member.login.auth');
Route::group(['prefix' => 'member'], function (){
    Route::get('/', [DashboardController::class, 'index']) ->name('member.dashboard');
});

