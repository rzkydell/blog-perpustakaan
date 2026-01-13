<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Editor tidak boleh publish / unpublish
        if (Auth::user()?->role !== 'admin') {
            $data['status'] = $this->record->status;
            $data['published_at'] = $this->record->published_at;
        }

        // Admin publish tapi tanggal kosong → isi otomatis
        if (
            Auth::user()?->role === 'admin' &&
            ($data['status'] ?? null) === 'published' &&
            empty($data['published_at'])
        ) {
            $data['published_at'] = now();
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => Auth::user()?->role === 'admin'),
        ];
    }
}
