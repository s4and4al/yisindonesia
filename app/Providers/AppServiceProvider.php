<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function (ViewInstance $view): void {
            $logoPath = SiteSetting::query()->find('branding')?->value['logo_path'] ?? null;

            $view->with(
                'brandLogoUrl',
                filled($logoPath) ? Storage::disk('public')->url($logoPath) : null,
            );
        });
    }
}
