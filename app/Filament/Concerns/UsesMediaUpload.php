<?php

namespace App\Filament\Concerns;

use App\Models\Media;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait UsesMediaUpload
{
    protected static function mediaUpload(string $field, string $label, string $altText): FileUpload
    {
        return FileUpload::make($field)
            ->label($label)
            ->image()
            ->disk('public')
            ->directory('media')
            ->maxSize(2048)
            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file) use ($altText): string {
                $path = $file->store('media', 'public');

                $media = Media::query()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'url' => $path,
                    'alt_text' => $altText,
                    'consent_ok' => true,
                ]);

                return $media->id;
            })
            ->getUploadedFileUsing(function (string $file): ?array {
                $media = Media::query()->find($file);

                if (! $media) {
                    return null;
                }

                return [
                    'name' => $media->file_name,
                    'size' => (int) $media->size_bytes,
                    'type' => $media->mime_type,
                    'url' => Storage::url($media->url),
                ];
            });
    }
}
