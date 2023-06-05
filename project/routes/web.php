<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('login');
    });

    Route::get('/register', function () {
        return view('register');
    });

    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user', function () {
        return view('user');
    });
    
    Route::get('/export', function () {
        return view('export');
    });
    
    Route::get('/import', function () {
        return view('import');
    });

    Route::post('/logout', function () {
        Auth::logout();
        return view('/login');
    })->name('logout');
});

/* 
===== Uncomment to enable JWT
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
*/

