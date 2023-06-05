<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name', 
        'developer_id', 
        'publisher_id', 
        'user_id'
    ];

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
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
