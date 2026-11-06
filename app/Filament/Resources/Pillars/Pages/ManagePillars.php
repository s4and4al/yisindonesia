<?php

namespace App\Filament\Resources\Pillars\Pages;

use App\Filament\Resources\Pillars\PillarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePillars extends ManageRecords
{
    protected static string $resource = PillarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
