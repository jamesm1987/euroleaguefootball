<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $fillable = [
        'api_id', 
        'league_id', 
        'home_team_id', 
        'away_team_id', 
        'home_team_score',
        'away_team_score',
        'date',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id', 'api_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id', 'api_id');
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
