<?php

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::resource('games', ApiController::class );

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::any('soap', function() {
    $server = new \nusoap_server();

    $server->configureWSDL('GameService', false, url('api/soap'));

    $server->soap_defencoding = 'UTF-8';
    $server->decode_utf8 = FALSE;

    function GetGameName($gameId)
    {
        $game = Game::find($gameId);

        // Sprawdź, czy gra o podanym id istnieje
        if (!$game) {
            return null;
        }
        
        $gameName = $game->name;

        return $gameName;
    }

    // Dodanie funkcji do SOAP
    $server->register('GetGameName',
        array('id' => 'xsd:string'),
        array('result' => 'xsd:string'),
    );

    $rawPostData = file_get_contents("php://input");
    return response($server->service($rawPostData), 200, array('Content-Type' => 'text/xml; charset=UTF-8'));
});

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user', [UserController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::get('games', [ApiController::class, 'index']);
    Route::post('games', [ApiController::class, 'store']);
    Route::get('games/{game}', [ApiController::class, 'show']);
    Route::put('games/{game}', [ApiController::class, 'update']);
    Route::delete('games/{game}', [ApiController::class, 'destroy']);
});