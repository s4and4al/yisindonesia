<?php

namespace App\Filament\Resources\LegalIdentities\Pages;

use App\Filament\Resources\LegalIdentities\LegalIdentityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLegalIdentities extends ManageRecords
{
    protected static string $resource = LegalIdentityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
