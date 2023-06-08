<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Isolation

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // REPEATABLE READ
    public function index()
    {
        $user = Auth::user();

        DB::beginTransaction();

        sleep(15);
        
        $games = Game::latest()->get();

        if ($user->isAdmin()) {
            $games = Game::with(['developers', 'publishers', 'user', 'steam', 'epic', 'genres'])
                ->latest()
                ->lockForUpdate()
                ->get();
        }
    
        // Commit the transaction
        DB::commit();
    
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
        // $request->validate([
        //     'title' => 'required',
        //     'body' => 'required',
        // ]);
 
        // $game = Game::create($request->all());
        // return [
        //     "status" => 1,
        //     "data" => $game
        // ];
        $user = Auth::user();
    
        if (!$user->isAdmin()) {
            return response()->json([
                'status' => 0,
                'message' => 'Unauthorized access',
            ], 401);
        }
        
        $data = $request->validate([
            'name' => 'required',
            'developers' => 'array',
            'publishers' => 'array',
            'genres' => 'array',
            'steam_price' => 'numeric',
            'steam_release_date' => 'date',
            'epic_price' => 'numeric',
            'epic_release_date' => 'date',
            // Add other validation rules for your input fields
        ]);
        
        $game = Game::create([
            'name' => $data['name'],
            'user_id' => $user->id,
        ]);
        
        // Attach developers
        if (isset($data['developers'])) {
            $game->developers()->attach($data['developers']);
        }
        
        // Attach publishers
        if (isset($data['publishers'])) {
            $game->publishers()->attach($data['publishers']);
        }
        
        // Attach genres
        if (isset($data['genres'])) {
            $game->genres()->attach($data['genres']);
        }
        
        // Create Steam entry
        if (isset($data['steam_price']) && isset($data['steam_release_date'])) {
            $game->steam()->create([
                'price' => $data['steam_price'],
                'release_date' => $data['steam_release_date'],
            ]);
        }

        // Create Epic entry
        if (isset($data['epic_price']) && isset($data['epic_release_date'])) {
            $game->epic()->create([
                'price' => $data['epic_price'],
                'release_date' => $data['epic_release_date'],
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Game created successfully',
            'data' => $game,
        ], 201);
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
