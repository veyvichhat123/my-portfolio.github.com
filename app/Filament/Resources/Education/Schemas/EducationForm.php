<?php

namespace App\Filament\Resources\Education\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class EducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Content')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('school_en')->label('School (English)')->required(),
                    TextInput::make('school_km')->label('School (Khmer)')->required(),

                    TextInput::make('degree_en')->label('Degree (English)')->required(),
                    TextInput::make('degree_km')->label('Degree (Khmer)')->required(),

                    TextInput::make('field_en')->label('Field of study (English)'),
                    TextInput::make('field_km')->label('Field of study (Khmer)'),

                    Textarea::make('description_en')->label('Short description (English)')->rows(3),
                    Textarea::make('description_km')->label('Short description (Khmer)')->rows(3),

                    RichEditor::make('content_en')
                        ->label('Details (English)')
                        ->fileAttachmentsDirectory('education/content')
                        ->columnSpanFull(),
                    RichEditor::make('content_km')
                        ->label('Details (Khmer)')
                        ->fileAttachmentsDirectory('education/content')
                        ->columnSpanFull(),
                ]),

            Section::make('Details')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    FileUpload::make('logo')
                        ->label('School logo')
                        ->image()
                        ->imageEditor()
                        ->directory('education/logos')
                        ->maxSize(2048)
                        ->columnSpanFull(),
                    DatePicker::make('start_date'),
                    DatePicker::make('end_date')
                        ->hidden(fn (Get $get): bool => (bool) $get('is_current')),
                    Toggle::make('is_current')->label('Currently studying')->live(),
                    TextInput::make('sort_order')->numeric()->default(0),
                    Toggle::make('is_active')->label('Active')->default(true),
                ]),
        ]);
    }
}
