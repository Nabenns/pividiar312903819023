<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                \Filament\Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                \Filament\Forms\Components\Select::make('role_name')
                    ->label('Role to Assign')
                    ->options(\Spatie\Permission\Models\Role::pluck('name', 'name'))
                    ->required()
                    ->helperText('The role assigned to the user when they purchase this plan.'),
                \Filament\Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR'),
                \Filament\Forms\Components\Select::make('billing_cycle')
                    ->options([
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                        'lifetime' => 'Lifetime',
                    ])
                    ->required(),
                \Filament\Forms\Components\KeyValue::make('features')
                    ->keyLabel('Feature Name')
                    ->valueLabel('Description')
                    ->columnSpanFull(),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
                \Filament\Forms\Components\Toggle::make('is_popular')
                    ->label('Is Popular?')
                    ->default(false),
            ]);
    }
}
