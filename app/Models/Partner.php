<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Partner extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'slug', 'logo_media_id', 'website_url', 'partner_type', 'show_logo',
    ];

    protected function casts(): array
    {
        return ['show_logo' => 'boolean'];
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_partners')->withPivot('role');
    }

    public function logo(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'logo_media_id');
    }
}
