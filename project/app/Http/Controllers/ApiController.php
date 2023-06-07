<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $games = Game::latest()->paginate(10);
        $games = Game::latest()->get();
        return [
            "status" => 1,
            "data" => $games
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
 
        $game = Game::create($request->all());
        return [
            "status" => 1,
            "data" => $game
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return [
            "status" => 1,
            "data" => $game
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required'
        ]);
 
        $game->update($request->all());
 
        return [
            "status" => 1,
            "data" => $game,
            "msg" => "Game updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return [
            "status" => 1,
            "data" => $game,
            "msg" => "Game deleted successfully"
        ];
    }
}
