<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentContents extends BaseWidget
{
    protected static ?string $heading = 'Artikel Terakhir Diperbarui';
    protected static ?int $sort = 2;

    protected function getTableQuery(): Builder
    {
        return Article::query()
            ->latest('updated_at');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')
                ->label('Judul')
                ->limit(40)
                ->searchable(),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->colors([
                    'secondary' => 'draft',
                    'success' => 'published',
                ]),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Terakhir Diperbarui')
                ->since(),
        ];
    }
}
