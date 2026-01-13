<?php

namespace App\Filament\Resources\LibraryInformationResource\Pages;

use App\Filament\Resources\LibraryInformationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateLibraryInformation extends CreateRecord
{
    protected static string $resource = LibraryInformationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set author
        $data['user_id'] = Auth::id();

        // Lock publish for non-admin
        if (Auth::user()?->role !== 'admin') {
            $data['status'] = 'draft';
            $data['published_at'] = null;
        }

        // Ensure published_at for admin publish
        if (
            Auth::user()?->role === 'admin' &&
            ($data['status'] ?? null) === 'published' &&
            empty($data['published_at'])
        ) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
