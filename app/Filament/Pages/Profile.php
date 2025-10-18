<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Profile extends Page
{
    protected string $view = 'filament.pages.profile';
    protected static ?string $title = 'Profile';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';
}
