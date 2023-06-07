<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use SimpleXMLElement;

class ExportController extends Controller
{
    public function exportCSV()
    {
        $games = Game::all();
        $fileName = 'games.csv';
        
        $file = fopen($fileName, 'w');
        $csvHeader = ['name', 'developer', 'publisher', 'genre', 'release_date_steam', 'price_steam', 'release_date_epic', 'price_epic'];
    
        fputcsv($file, $csvHeader, ';');
    
        foreach ($games as $game) {
            $developers = $game->developers->pluck('name')->implode(';');
            $publishers = $game->publishers->pluck('name')->implode(';');
            $genres = $game->genres->pluck('name')->implode(';');
    
            $steamReleaseDate = $game->steam->release_date;
            $steamPrice = $game->steam->price;
            $epicReleaseDate = $game->epic->release_date;
            $epicPrice = $game->epic->price;
    
            fputcsv($file, [$game->name, $developers, $publishers, $genres, $steamReleaseDate, $steamPrice, $epicReleaseDate, $epicPrice], ';');
        }
    
        fclose($file);
    
        return response()->download($fileName)->deleteFileAfterSend(true);
    }

    public function exportJSON()
    {
        $games = Game::all();
        $data = [];

        foreach ($games as $game) {
            $developers = $game->developers->pluck('name')->toArray();
            $publishers = $game->publishers->pluck('name')->toArray();
            $genres = $game->genres->pluck('name')->toArray();

            $steamReleaseDate = $game->steam->release_date;
            $steamPrice = $game->steam->price;
            $epicReleaseDate = $game->epic->release_date;
            $epicPrice = $game->epic->price;

            $data[] = [
                'name' => $game->name,
                'developer' => $developers,
                'publisher' => $publishers,
                'genre' => $genres,
                'steam' => [
                    'release_date' => $steamReleaseDate,
                    'price' => $steamPrice,
                ],
                'epic' => [
                    'release_date' => $epicReleaseDate,
                    'price' => $epicPrice,
                ],
            ];
        }

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $fileName = 'games.json';

        file_put_contents($fileName, $jsonData);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }

    public function exportXML()
    {
        $games = Game::all();
        $xmlData = new SimpleXMLElement('<games></games>');
    
        foreach ($games as $game) {
            $gameElement = $xmlData->addChild('game');
            $gameElement->addChild('name', htmlspecialchars($game->name));
    
            $developersElement = $gameElement->addChild('developers');
            foreach ($game->developers as $developer) {
                $developersElement->addChild('developer', htmlspecialchars($developer->name));
            }
    
            $publishersElement = $gameElement->addChild('publishers');
            foreach ($game->publishers as $publisher) {
                $publishersElement->addChild('publisher', htmlspecialchars($publisher->name));
            }
    
            $genresElement = $gameElement->addChild('genres');
            foreach ($game->genres as $genre) {
                $genresElement->addChild('genre', htmlspecialchars($genre->name));
            }
    
            $steamElement = $gameElement->addChild('steam');
            $steamElement->addChild('release_date', $game->steam->release_date);
            $steamElement->addChild('price', $game->steam->price);
    
            $epicElement = $gameElement->addChild('epic');
            $epicElement->addChild('release_date', $game->epic->release_date);
            $epicElement->addChild('price', $game->epic->price);
        }
    
        $dom = dom_import_simplexml($xmlData)->ownerDocument;
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $xmlDataFormatted = $dom->saveXML();
    
        $fileName = 'games.xml';
        file_put_contents($fileName, $xmlDataFormatted);
    
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
