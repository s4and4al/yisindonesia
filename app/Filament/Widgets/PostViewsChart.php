<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

class PostViewsChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Pembaca';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $posts = Post::query()->published()->orderByDesc('view_count')->limit(8)->get();

        return [
            'datasets' => [
                [
                    'label' => 'Dibaca',
                    'data' => $posts->pluck('view_count')->all(),
                    'backgroundColor' => '#17633f',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $posts->pluck('title')->map(fn (string $title) => Str::limit($title, 24))->all(),
        ];
    }
}
