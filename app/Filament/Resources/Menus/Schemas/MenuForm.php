<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title_en')
                ->label('Title (English)')
                ->required(),

            TextInput::make('title_km')
                ->label('Title (Khmer)'),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Select::make('parent_id')
                ->label('Parent Menu')
                ->relationship('parent', 'title_en')
                ->searchable()
                ->preload(),

            // Adjust these options to match the values your app uses
            Select::make('page_type')
                ->options([
                    'page' => 'Page',
                    'link' => 'Link',
                ]),

            TextInput::make('sort_order')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->label('Active')
                ->default(true),
        ]);
    }
}
