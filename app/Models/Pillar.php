<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pillar extends Model
{
    protected $fillable = ['name', 'slug', 'summary', 'color_hex', 'sort_order'];

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_pillars');
    }
}
