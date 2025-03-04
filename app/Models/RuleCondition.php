<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleCondition extends Model
{

    protected $fillable = [
        'scenario_id',
        'column_a',
        'operator',
        'column_b',
        'static_value',
    ];

    public function scenario()
    {
        return $this->belongsTo(RuleScenario::class);
    }
}
