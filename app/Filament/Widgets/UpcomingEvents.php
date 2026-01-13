<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingEvents extends BaseWidget
{
    protected static ?string $heading = 'Event Terdekat';
    protected static ?int $sort = 3;

    protected function getTableQuery(): Builder
    {
        return Event::query()
            ->whereDate('event_date', '>=', now())
            ->where('status', 'published')
            ->orderBy('event_date');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')
                ->label('Judul')
                ->limit(40),

            Tables\Columns\TextColumn::make('event_date')
                ->label('Tanggal')
                ->date('d M Y'),

            Tables\Columns\TextColumn::make('location')
                ->label('Lokasi')
                ->limit(25),
        ];
    }
}
