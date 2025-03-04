<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleAction extends Model
{
    protected $fillable = [
        'scenario_id',
        'awarded_team',
        'points',
    ];

    public function scenario()
    {
        return $this->belongsTo(RuleScenario::class);
    }
}
