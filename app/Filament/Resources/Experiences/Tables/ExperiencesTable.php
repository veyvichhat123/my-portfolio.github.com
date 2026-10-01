<?php

namespace App\Filament\Resources\Experiences\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->circular(),
                TextColumn::make('company_en')->label('Company (EN)')->searchable()->sortable(),
                TextColumn::make('company_km')->label('Company (KM)')->searchable(),
                TextColumn::make('position_en')->label('Position (EN)')->searchable(),
                TextColumn::make('position_km')->label('Position (KM)'),
                TextColumn::make('start_date')->date('M Y')->sortable(),
                TextColumn::make('end_date')->date('M Y')->placeholder('Present')->sortable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean(),
            ])
            ->defaultSort('sort_order')
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
