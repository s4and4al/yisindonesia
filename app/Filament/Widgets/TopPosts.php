<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class TopPosts extends TableWidget
{
    protected function getTableHeading(): string
    {
        return 'Berita Terpopuler';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query()->published()->orderByDesc('view_count')->limit(5))
            ->columns([
                TextColumn::make('title')->label('Judul')->limit(50),
                TextColumn::make('view_count')->label('Dibaca')->numeric()->sortable(),
                TextColumn::make('published_at')->label('Terbit')->dateTime('d M Y'),
            ])
            ->paginated(false);
    }
}
