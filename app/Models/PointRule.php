<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class PointRule extends Model
{
    protected $fillable = ['name', 'description'];

    public function scenarios(): HasMany
    {
        return $this->hasMany(RuleScenario::class);
    }

}
