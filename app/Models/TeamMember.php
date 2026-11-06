<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'position', 'group_name', 'division', 'bio', 'photo_media_id',
        'sort_order', 'is_visible',
    ];

    protected function casts(): array
    {
        return ['is_visible' => 'boolean'];
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'photo_media_id');
    }
}
