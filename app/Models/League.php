<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = [
        'name',
        'api_id',
        'country',
    ];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function fixtures()
    {
        return $this->hasMany(Fixture::class);
    }
}
