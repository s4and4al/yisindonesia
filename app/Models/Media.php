<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class Media extends Model
{
    use HasUuids;

    protected $fillable = [
        'file_name', 'url', 'alt_text', 'credit', 'consent_ok', 'uploaded_by',
    ];

    protected function casts(): array
    {
        return ['consent_ok' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (Media $media): void {
            if (blank($media->url) || ! Storage::disk('public')->exists($media->url)) {
                return;
            }

            $disk = Storage::disk('public');
            $media->mime_type = $disk->mimeType($media->url) ?: 'application/octet-stream';
            $media->size_bytes = $disk->size($media->url);
            $media->uploaded_by ??= auth()->id();

            if (str_starts_with($media->mime_type, 'image/')) {
                if (blank($media->alt_text)) {
                    throw ValidationException::withMessages([
                        'alt_text' => 'Teks alternatif wajib diisi untuk gambar.',
                    ]);
                }

                $dimensions = getimagesize($disk->path($media->url));
                if ($dimensions === false) {
                    throw ValidationException::withMessages([
                        'url' => 'File gambar tidak dapat dibaca.',
                    ]);
                }

                $media->width = $dimensions[0];
                $media->height = $dimensions[1];
            }
        });
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
