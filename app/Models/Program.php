<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    use HasUuids;

    protected $fillable = [
        'title', 'slug', 'summary', 'description', 'focus_activity', 'location',
        'province', 'year_start', 'year_end', 'status', 'cover_media_id',
        'impact_summary', 'is_featured', 'publish_status', 'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'year_start' => 'integer',
            'year_end' => 'integer',
            'is_featured' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('publish_status', 'published');
    }

    public function pillars(): BelongsToMany
    {
        return $this->belongsToMany(Pillar::class, 'program_pillars');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'program_posts');
    }

    public function partners(): BelongsToMany
    {
        return $this->belongsToMany(Partner::class, 'program_partners')->withPivot('role');
    }

    public function coverMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cover_media_id');
    }
}
