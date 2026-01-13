<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\News;
use App\Models\Event;
use App\Models\LibraryInformation;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ContentStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        $articleQuery = Article::query();
        $newsQuery = News::query();
        $eventQuery = Event::query();
        $libraryInfoQuery = LibraryInformation::query();

        // Editor hanya lihat data miliknya
        if ($user->role === 'editor') {
            $articleQuery->where('user_id', $user->id);
            $newsQuery->where('user_id', $user->id);
            $eventQuery->where('user_id', $user->id);
            $libraryInfoQuery->where('user_id', $user->id);
        }

        return [
            Stat::make('Artikel', $articleQuery->count())
                ->icon('heroicon-o-document-text'),

            Stat::make('Berita', $newsQuery->count())
                ->icon('heroicon-o-newspaper'),

            Stat::make('Event', $eventQuery->count())
                ->icon('heroicon-o-calendar-days'),

            Stat::make('Informasi Perpustakaan', $libraryInfoQuery->count())
                ->icon('heroicon-o-building-library'),
        ];
    }
}
