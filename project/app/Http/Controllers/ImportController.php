<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Developer;
use App\Models\Publisher;
use App\Models\Genre;
use App\Models\Epic;
use App\Models\Steam;

class ImportController extends Controller
{
    function importCSV(Request $request)
    {
        $file = $request->file('import-as-csv');
        $filePath = $file->getPathname();
    
        $csvFileHandle = fopen($filePath, 'r');
        if ($csvFileHandle === false) {
            die("Nie można otworzyć pliku CSV");
        }
    
        $header = fgetcsv($csvFileHandle, 0, ';');
        $header[0] = str_replace("\u{FEFF}", '', $header[0]);
        $expectedColumns = ['name', 'developer', 'publisher', 'genres', 'release_date_steam', 'price_steam', 'release_date_epic', 'price_epic'];
    
        if ($header !== $expectedColumns) {
            die("Nieprawidłowy format pliku CSV. Oczekiwane kolumny: " . implode(', ', $expectedColumns));
        }
    
        while (($data = fgetcsv($csvFileHandle, 0, ';')) !== false) {
            $gameName = $data[0];
            $gameDevelopers = explode(';', $data[1]);
            $gamePublishers = explode(';', $data[2]);
            $gameGenres = explode(';', $data[3]);
            $gameReleaseDateSteam = $data[4];
            $gamePriceSteam = str_replace(',', '.', $data[5]);
            $gameReleaseDateEpic = $data[6];
            $gamePriceEpic = str_replace(',', '.', $data[7]);
    
            if (Game::where('name', $gameName)->exists()) {
                continue;
            }
    
            $genreIds = [];
            foreach ($gameGenres as $genre) {
                $genre = trim($genre);
                $existingGenre = Genre::where('name', $genre)->first();
                if (!$existingGenre) {
                    $newGenre = Genre::create(['name' => $genre]);
                    $genreIds[] = $newGenre->id;
                } else {
                    $genreIds[] = $existingGenre->id;
                }
            }
    
            $game = Game::create([
                'name' => $gameName,
                'user_id' => auth()->user()->id,
            ]);
    
            foreach ($gameDevelopers as $developerName) {
                $developerName = trim($developerName);
                $developer = Developer::firstOrCreate(['name' => $developerName]);
                $game->developers()->attach($developer->id);
            }
    
            foreach ($gamePublishers as $publisherName) {
                $publisherName = trim($publisherName);
                $publisher = Publisher::firstOrCreate(['name' => $publisherName]);
                $game->publishers()->attach($publisher->id);
            }
    
            $game->genres()->attach($genreIds);
    
            Steam::create([
                'price' => $gamePriceSteam,
                'release_date' => $gameReleaseDateSteam,
                'game_id' => $game->id,
            ]);
    
            Epic::create([
                'price' => $gamePriceEpic,
                'release_date' => $gameReleaseDateEpic,
                'game_id' => $game->id,
            ]);
        }
    
        fclose($csvFileHandle);
    
        return redirect('/')->with('message', 'Games added.');
    } 
    
    public function showGames()
    {
        $games = Game::with(['developers', 'publishers', 'genres', 'steam', 'epic'])->get();
        return view('welcome', ['games' => $games]);
    }
}