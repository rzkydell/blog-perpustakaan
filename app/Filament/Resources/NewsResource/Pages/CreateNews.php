<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set author
        $data['user_id'] = Auth::id();

        // Lock publish for non-admin
        if (Auth::user()?->role !== 'admin') {
            $data['status'] = 'draft';
            $data['published_at'] = null;
        }

        // Auto set publish date for admin
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
