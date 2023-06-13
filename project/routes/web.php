<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

Route::get('/', [GameController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/user', function () {
        return view('user');
    });
    
    Route::get('/export', function () {
        return view('export');
    });
    
    Route::get('/import', function () {
        return view('import');
    });

    Route::post('/import-csv', [ImportController::class, 'importCSV']);
    Route::post('/import-json', [ImportController::class, 'importJSON']);
    Route::post('/import-xml', [ImportController::class, 'importXML']);

    Route::post('/export-csv', [ExportController::class, 'exportCSV']);
    Route::post('/export-json', [ExportController::class, 'exportJSON']);
    Route::post('/export-xml', [ExportController::class, 'exportXML']);

    Route::delete('/remove/{game}', [GameController::class, 'delete']);

    Route::post('/logout', function () {
        Auth::logout();
        return view('/login');
    })->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('login');
    });

    Route::get('/register', function () {
        return view('register');
    });

    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});


// Route::middleware(['guest'])->group(function () {
//     Route::get('/login', function () {
//         return view('login');
//     });

//     Route::get('/register', function () {
//         return view('register');
//     });

//     Route::post('/login', [UserController::class, 'authenticate'])->name('login');
//     Route::post('/register', [UserController::class, 'register']);
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/user', function () {
//         return view('user');
//     });
    
//     Route::get('/export', function () {
//         return view('export');
//     });
    
//     Route::get('/import', function () {
//         return view('import');
//     });

//     Route::post('/import-csv', [ImportController::class, 'importCSV']);
//     Route::post('/import-json', [ImportController::class, 'importJSON']);
//     Route::post('/import-xml', [ImportController::class, 'importXML']);

//     Route::post('/logout', function () {
//         Auth::logout();
//         return view('/login');
//     })->name('logout');
// });


