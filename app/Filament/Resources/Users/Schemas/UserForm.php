<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255)
                ->disabled(fn($record) => $record?->role === 'superadmin'), // ✅ Protect superadmin name,

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255)
                ->disabled(fn($record) => $record?->role === 'superadmin'), // ✅ Protect superadmin email

            Select::make('role')
                ->label('Role')
                ->options([
                    'superadmin' => 'Super Admin',
                    'admin' => 'Admin',
                    'user' => 'User',
                ])
                ->default('user')
                ->required()
                ->disabled(fn($record) => $record?->role === 'superadmin'), // ✅ Superadmin role locked

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                ->required(fn(string $context): bool => $context === 'create')
                ->maxLength(255)
                ->disabled(fn($record) => $record?->role === 'superadmin'), // ✅ Prevent changing superadmin password
        ]);
    }
}
