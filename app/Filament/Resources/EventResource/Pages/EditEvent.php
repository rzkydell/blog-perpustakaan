<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Editor tidak boleh mengubah status & tanggal publish
        if (Auth::user()?->role !== 'admin') {
            $data['status'] = $this->record->status;
            $data['published_at'] = $this->record->published_at;
        }

        // Admin publish tapi lupa isi tanggal → isi otomatis
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
