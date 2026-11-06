<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasUuids;

    protected $fillable = [
        'title', 'doc_type', 'description', 'media_id', 'year', 'program_id',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_public' => 'boolean',
        ];
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
