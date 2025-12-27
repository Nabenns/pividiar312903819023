<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $revenue = \App\Models\Transaction::where('status', 'paid')->sum('amount');
        $activeMembers = \App\Models\Subscription::where('status', 'active')->count();

        return [
            Stat::make('Total Revenue', 'IDR ' . number_format($revenue, 0, ',', '.')),
            Stat::make('Active Members', $activeMembers),
        ];
    }
}
