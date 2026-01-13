<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\ContentStats;
use App\Filament\Widgets\RecentContents;
use App\Filament\Widgets\UpcomingEvents;
use App\Filament\Widgets\QuickActions;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        $widgets = [
            ContentStats::class,
            RecentContents::class,
            UpcomingEvents::class,
        ];

        return $widgets;
    }
}
