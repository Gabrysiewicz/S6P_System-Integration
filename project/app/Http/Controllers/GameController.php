<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['developers', 'publishers', 'genres', 'steam', 'epic'])->get();
        return view('welcome', ['games' => $games]);
    }

    public function delete(Game $game)
    {
        if(!auth()->user()->isAdmin()){
            return redirect('/');
        }

        $game->delete();

        return redirect('/')->with('message', 'Game deleted successfully');
    }
}
