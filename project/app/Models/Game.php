<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'game';
    protected $fillable = [
        'name',  
        'user_id',
    ];

    public function developers()
    {
        return $this->belongsToMany(Developer::class, 'game_developer');
    }

    public function publishers()
    {
        return $this->belongsToMany(Publisher::class, 'game_publisher');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steam()
    {
        return $this->hasOne(Steam::class);
    }

    public function epic()
    {
        return $this->hasOne(Epic::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'game_genre');
    }
}
