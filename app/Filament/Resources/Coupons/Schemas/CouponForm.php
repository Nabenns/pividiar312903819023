<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Coupon Details')
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_active')
                            ->required()
                            ->default(true),
                        
                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                Select::make('discount_type')
                                    ->options([
                                        'fixed' => 'Fixed Amount (IDR)',
                                        'percent' => 'Percentage (%)',
                                    ])
                                    ->required()
                                    ->default('percent'),
                                TextInput::make('discount_amount')
                                    ->required()
                                    ->numeric()
                                    ->label('Discount Value'),
                            ]),

                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('max_uses')
                                    ->numeric()
                                    ->label('Max Usage Limit')
                                    ->placeholder('Unlimited'),
                                DateTimePicker::make('expires_at')
                                    ->label('Expiration Date'),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('Affiliate Settings')
                    ->description('Link this coupon to a user to track commissions.')
                    ->schema([
                        Select::make('affiliate_user_id')
                            ->relationship('affiliate', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Affiliate User'),
                        
                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                Select::make('commission_type')
                                    ->options([
                                        'fixed' => 'Fixed Amount (IDR)',
                                        'percent' => 'Percentage (%)',
                                    ])
                                    ->default('percent')
                                    ->required(),
                                TextInput::make('commission_amount')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->label('Commission Value'),
                            ]),
                    ]),
            ]);
    }
}
