<?php

namespace App\Filament\Resources\Experiences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Content')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('company_en')->label('Company (English)')->required(),
                    TextInput::make('company_km')->label('Company (Khmer)')->required(),

                    TextInput::make('position_en')->label('Position (English)')->required(),
                    TextInput::make('position_km')->label('Position (Khmer)')->required(),

                    TextInput::make('location_en')->label('Location (English)'),
                    TextInput::make('location_km')->label('Location (Khmer)'),

                    Textarea::make('description_en')->label('Short description (English)')->rows(3),
                    Textarea::make('description_km')->label('Short description (Khmer)')->rows(3),

                    RichEditor::make('content_en')
                        ->label('Responsibilities / Achievements (English)')
                        ->fileAttachmentsDirectory('experiences/content')
                        ->columnSpanFull(),
                    RichEditor::make('content_km')
                        ->label('Responsibilities / Achievements (Khmer)')
                        ->fileAttachmentsDirectory('experiences/content')
                        ->columnSpanFull(),
                ]),

            Section::make('Details')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    FileUpload::make('logo')
                        ->label('Company logo')
                        ->image()
                        ->imageEditor()
                        ->directory('experiences/logos')
                        ->maxSize(2048)
                        ->columnSpanFull(),
                    DatePicker::make('start_date'),
                    DatePicker::make('end_date')
                        ->hidden(fn (Get $get): bool => (bool) $get('is_current')),
                    Toggle::make('is_current')->label('Currently working here')->live(),
                    TextInput::make('sort_order')->numeric()->default(0),
                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }
}
