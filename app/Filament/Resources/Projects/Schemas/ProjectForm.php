<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Content')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('title_en')->label('Title (English)')->required(),
                    TextInput::make('title_km')->label('Title (Khmer)')->required(),

                    Textarea::make('description_en')
                        ->label('Short description (English)')
                        ->rows(3)
                        ->helperText('Shown on project cards.'),
                    Textarea::make('description_km')
                        ->label('Short description (Khmer)')
                        ->rows(3),

                    RichEditor::make('content_en')
                        ->label('Highlights / User guide (English)')
                        ->fileAttachmentsDirectory('projects/content')
                        ->columnSpanFull(),
                    RichEditor::make('content_km')
                        ->label('Highlights / User guide (Khmer)')
                        ->fileAttachmentsDirectory('projects/content')
                        ->columnSpanFull(),
                ]),

            Section::make('Media')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    FileUpload::make('thumbnail')
                        ->image()
                        ->imageEditor()
                        ->directory('projects/thumbnails')
                        ->maxSize(2048),

                    FileUpload::make('gallery')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->directory('projects/gallery')
                        ->maxSize(4096),

                    TextInput::make('video_url')
                        ->label('Video URL (YouTube / Vimeo)')
                        ->url()
                        ->columnSpanFull(),

                    FileUpload::make('video_file')
                        ->label('Or upload a video (optional)')
                        ->acceptedFileTypes(['video/mp4', 'video/webm'])
                        ->directory('projects/videos')
                        ->maxSize(51200) // 50 MB
                        ->columnSpanFull(),
                ]),

            Section::make('Details')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('url')->label('Live URL')->url(),
                    TextInput::make('github_url')->label('GitHub URL')->url(),
                    TagsInput::make('technologies')->columnSpanFull(),
                    Toggle::make('is_featured')->label('Featured'),
                    Toggle::make('is_active')->label('Active')->default(true),
                    TextInput::make('sort_order')->numeric()->default(0),
                ]),
        ]);
    }
}
