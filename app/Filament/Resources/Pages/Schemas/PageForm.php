<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page Info')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title_en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) =>
                                $set('slug', Str::slug($state ?? ''))
                            ),

                        TextInput::make('title_km')
                            ->label('Title (Khmer)')
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->required()
                            ->alphaDash()
                            ->unique(ignoreRecord: true)
                            ->helperText('Used in the URL: /page/your-slug. Must match the slug in the Menu.')
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),

                Section::make('Content')
                    ->schema([
                        RichEditor::make('content_en')
                            ->label('Content (English)')
                            ->columnSpanFull(),

                        RichEditor::make('content_km')
                            ->label('Content (Khmer)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
