<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends StatsOverviewWidget
{
    // Make it take half of the dashboard width
    // protected int|string|array $columnSpan = -2;
    protected int|string|array $columnSpan = 6;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::where('role', 'user')->count())
                ->description('All regular users')
                ->descriptionIcon('heroicon-o-user')
                ->color('primary'),

            Stat::make('Total Admins', User::where('role', 'admin')->count())
                ->description('All admins')
                ->descriptionIcon('heroicon-o-shield-check')
                ->color('success'),

            Stat::make('Super Admin', User::where('role', 'superadmin')->count())
                ->description('Main superadmin')
                ->descriptionIcon('heroicon-o-star')
                ->color('danger'),
        ];
    }
}
