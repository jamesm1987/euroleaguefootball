<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleScenario extends Model
{
    protected $fillable = ['column_a', 'operator', 'column_b', 'static_value', 'awarded_team', 'points'];

    protected $casts = [
        'conditions' => 'array',  // Cast conditions and actions to array
        'actions' => 'array',
    ];

    public function pointRule()
    {
        return $this->belongsTo(PointRule::class);
    }

    public function conditions()
    {
        return $this->hasMany(RuleCondition::class);
    }

    public function actions()
    {
        return $this->hasMany(RuleAction::class);
    }
}
