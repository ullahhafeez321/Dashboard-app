<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    // ✅ This must be non-static
    protected string $view = 'filament.pages.dashboard';

    // ✅ This is static
    protected static ?string $title = 'Dashboard';

    // ✅ This is static
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';
}
