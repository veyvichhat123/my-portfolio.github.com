<?php

namespace App\Filament\Resources\Education\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EducationTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->circular(),
                TextColumn::make('school_en')->label('School (EN)')->searchable()->sortable(),
                TextColumn::make('school_km')->label('School (KM)')->searchable(),
                TextColumn::make('degree_en')->label('Degree (EN)')->searchable(),
                TextColumn::make('degree_km')->label('Degree (KM)'),
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
