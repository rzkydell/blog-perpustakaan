<?php

namespace App\Filament\Resources\LibraryInformationResource\Pages;

use App\Filament\Resources\LibraryInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLibraryInformations extends ListRecords
{
    protected static string $resource = LibraryInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
