<?php

namespace App\Filament\Resources\Coupons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('discount_amount')
                    ->formatStateUsing(fn ($state, $record) => $record->discount_type === 'fixed' ? 'IDR ' . number_format($state) : $state . '%')
                    ->label('Discount'),
                TextColumn::make('uses')
                    ->numeric()
                    ->sortable()
                    ->label('Usage'),
                TextColumn::make('max_uses')
                    ->numeric()
                    ->sortable()
                    ->placeholder('Unlimited'),
                TextColumn::make('affiliate.name')
                    ->label('Affiliate')
                    ->searchable()
                    ->placeholder('None'),
                TextColumn::make('commission_amount')
                    ->formatStateUsing(fn ($state, $record) => $record->commission_type === 'fixed' ? 'IDR ' . number_format($state) : $state . '%')
                    ->label('Commission'),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
