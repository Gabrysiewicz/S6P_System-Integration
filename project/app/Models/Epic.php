<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Epic extends Model
{
    protected $fillable = [
        'price', 
        'release_date', 
        'game_id'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
