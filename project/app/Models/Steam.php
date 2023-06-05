<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Steam extends Model
{
    public $timestamps = false;
    protected $table = 'steam';
    protected $fillable = [
        'price', 
        'release_date', 
        'game_id',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
