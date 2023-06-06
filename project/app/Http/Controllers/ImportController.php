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
           $this->processGameData($data, "csv");
        }
    
        fclose($csvFileHandle);
    
        return redirect('/')->with('message', 'Games added.');
    } 

    function importJSON(Request $request)
    {
        $file = $request->file('import-as-json');
        $filePath = $file->getPathname();

        $jsonData = file_get_contents($filePath);
        $jsonArray = json_decode($jsonData, true);

        if (!$jsonArray) {
            die("Nieprawidłowy format pliku JSON");
        }   

        if (is_array($jsonArray)) {
            if (array_keys($jsonArray) === range(0, count($jsonArray) - 1)) {
                foreach ($jsonArray as $game) {
                    $this->processGameData($game, "json");
                }
            } else {
                $this->processGameData($jsonArray, "json");
            }
        }

        return redirect('/')->with('message', 'Games added.');
    }

    function processGameData($data, $type)
    {
        if ($type == "csv") {
            $gameName = $data[0];
            $gameDevelopers = explode(';', $data[1]);
            $gamePublishers = explode(';', $data[2]);
            $gameGenres = explode(';', $data[3]);
            $gameReleaseDateSteam = date('Y-m-d', strtotime(str_replace('.', '-', $data[4])));
            $gamePriceSteam = str_replace(',', '.', $data[5]);
            $gameReleaseDateEpic = date('Y-m-d', strtotime(str_replace('.', '-', $data[6])));
            $gamePriceEpic = str_replace(',', '.', $data[7]);
        } else {
            $gameName = $data['name'];
            $gameDevelopers = is_array($data['developer']) ? $data['developer'] : [$data['developer']];
            $gamePublishers = is_array($data['publisher']) ? $data['publisher'] : [$data['publisher']];
            $gameGenres = is_array($data['genres']) ? $data['genres'] : [$data['genres']];
            $gameReleaseDateSteam = date('Y-m-d', strtotime(str_replace('.', '-', $data['steam']['release_date'])));
            $gamePriceSteam = str_replace(',', '.', $data['steam']['price']);
            $gameReleaseDateEpic = date('Y-m-d', strtotime(str_replace('.', '-', $data['epic']['release_date'])));
            $gamePriceEpic = str_replace(',', '.', $data['epic']['price']);
        }

        if (empty($gameName) || empty($gameDevelopers) || empty($gamePublishers) || empty($gameGenres) || empty($gameReleaseDateSteam) || empty($gamePriceSteam) || empty($gameReleaseDateEpic) || empty($gamePriceEpic)) {
            return;
        }

        if (Game::where('name', $gameName)->exists()) {
            return;
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
    
    public function showGames()
    {
        $games = Game::with(['developers', 'publishers', 'genres', 'steam', 'epic'])->get();
        return view('welcome', ['games' => $games]);
    }
}