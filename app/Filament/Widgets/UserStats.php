<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::where('role', 'user')->count())
                ->description('All regular users')
                ->descriptionIcon('heroicon-o-user') // ✅ valid icon
                ->color('primary'),

            Stat::make('Total Admins', User::where('role', 'admin')->count())
                ->description('All admins')
                ->descriptionIcon('heroicon-o-shield-check') // ✅ valid icon
                ->color('success'),

            Stat::make('Super Admin', User::where('role', 'superadmin')->count())
                ->description('Main superadmin')
                ->descriptionIcon('heroicon-o-star') // ✅ replaced with valid icon
                ->color('danger'),
        ];
    }
}
