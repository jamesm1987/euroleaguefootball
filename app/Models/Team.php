<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['api_id', 'name', 'display_name', 'league_id'];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

}
