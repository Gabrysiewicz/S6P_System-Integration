<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    public $timestamps = false;
    protected $table = 'publisher';
    protected $fillable = [
        'name',
    ];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_publisher');
    }
}
