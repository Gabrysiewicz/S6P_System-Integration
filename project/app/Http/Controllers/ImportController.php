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
        $expectedColumns = ['name', 'developer', 'publisher', 'genre', 'release_date_steam', 'price_steam', 'release_date_epic', 'price_epic'];
    
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

    function importXML(Request $request)
    {
        $file = $request->file('import-as-xml');
        $filePath = $file->getPathname();

        $xmlData = file_get_contents($filePath);
        $games = simplexml_load_string($xmlData);

        if (!$games) {
            die("Nieprawidłowy format pliku XML");
        }

        if ($games instanceof SimpleXMLElement) {
            $this->processGameData($games, "xml");
        } else {
            foreach ($games as $game) {
                $this->processGameData($game, "xml");
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
        } else if ($type == "json") {
            if (!isset($data['name']) || !isset($data['developer']) || !isset($data['publisher']) || !isset($data['genre']) || !isset($data['steam']['release_date']) || !isset($data['steam']['price']) || !isset($data['epic']['release_date']) || !isset($data['epic']['price'])) {
                die("Brakuje jednego lub więcej kluczy w pliku JSON");
            }
            
            $gameName = $data['name'];
            $gameDevelopers = is_array($data['developer']) ? $data['developer'] : [$data['developer']];
            $gamePublishers = is_array($data['publisher']) ? $data['publisher'] : [$data['publisher']];
            $gameGenres = is_array($data['genre']) ? $data['genre'] : [$data['genre']];
            $gameReleaseDateSteam = date('Y-m-d', strtotime(str_replace('.', '-', $data['steam']['release_date'])));
            $gamePriceSteam = str_replace(',', '.', $data['steam']['price']);
            $gameReleaseDateEpic = date('Y-m-d', strtotime(str_replace('.', '-', $data['epic']['release_date'])));
            $gamePriceEpic = str_replace(',', '.', $data['epic']['price']);
        } else { //xml         
            // Sprawdzenie poprawności znaczników
            if (!$data->name || !$data->developers || !$data->publishers || !$data->genre || !$data->steam || !$data->epic) {
                return;
            }
            $gameName = (string)$data->name;
            $gameDevelopers = [];
            $gamePublishers = [];
            $gameGenres = [];
            $gameReleaseDateSteam = '';
            $gamePriceSteam = '';
            $gameReleaseDateEpic = '';
            $gamePriceEpic = '';

            foreach ($data->developers->developer as $developer) {
                $gameDevelopers[] = (string)$developer;
            }

            foreach ($data->publishers->publisher as $publisher) {
                $gamePublishers[] = (string)$publisher;
            }

            foreach ($data->genres->genre as $genre) {
                $gameGenres[] = (string)$genre;
            }

            $gameReleaseDateSteam = date('Y-m-d', strtotime(str_replace('.', '-', (string)$data->steam->release_date)));
            $gamePriceSteam = str_replace(',', '.', (string)$data->steam->price);

            $gameReleaseDateEpic = date('Y-m-d', strtotime(str_replace('.', '-', (string)$data->epic->release_date)));
            $gamePriceEpic = str_replace(',', '.', (string)$data->epic->price);
        }

        if (empty($gameName) || empty($gameDevelopers) || empty($gamePublishers) || empty($gameGenres) || empty($gameReleaseDateSteam) || empty($gamePriceSteam) || empty($gameReleaseDateEpic) || empty($gamePriceEpic)) {
            return;
        }
        
        $gameName = trim($gameName);

        if (Game::where('name', $gameName)->exists()) {
            return;
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

        foreach ($gameGenres as $genreName) {
            $genreName = trim($genreName);
            $genre = Genre::firstOrCreate(['name' => $genreName]);
            $game->genres()->attach($genre->id);
        }

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