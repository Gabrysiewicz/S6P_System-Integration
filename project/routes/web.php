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

Route::get('/login', function () {
    return view('login');
});

Route::get('/import', function () {
    return view('import');
});

Route::get('/export', function () {
    return view('export');
});

// Route::get('/register', function () {
//     return view('register');
// });
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/user', [UserController::class, 'store']);


/* 
===== Uncomment to enable JWT
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
*/

