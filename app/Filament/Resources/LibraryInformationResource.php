<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryInformationResource\Pages;
use App\Models\LibraryInformation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LibraryInformationResource extends Resource
{
    protected static ?string $model = LibraryInformation::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Library Management';
    protected static ?string $navigationLabel = 'Library Information';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Information Content')
                ->schema([
                    Forms\Components\FileUpload::make('banner')
                        ->image()
                        ->directory('library-information-banners')
                        ->imageEditor()
                        ->maxSize(2048)
                        ->requiredIf('status', 'published')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn (string $state, callable $set) =>
                                $set('slug', Str::slug($state))
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\Select::make('type')
                        ->options([
                            'profile'  => 'Profile',
                            'service'  => 'Services',
                            'rule'     => 'Rules',
                            'facility' => 'Facilities',
                            'contact'  => 'Contact',
                            'other'    => 'Other',
                        ])
                        ->required(),

                    Forms\Components\RichEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Publication')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->default('draft')
                        ->required()
                        ->disabled(fn () => Auth::user()?->role !== 'admin')
                        ->live(),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Tanggal Publikasi')
                        ->visible(fn ($get) => $get('status') === 'published')
                        ->requiredIf('status', 'published')
                        ->disabled(fn () => Auth::user()?->role !== 'admin'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'info' => 'profile',
                        'success' => 'service',
                        'warning' => 'rule',
                        'primary' => 'facility',
                        'secondary' => 'contact',
                    ]),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                    ]),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => Auth::user()?->role === 'admin'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLibraryInformations::route('/'),
            'create' => Pages\CreateLibraryInformation::route('/create'),
            'edit'   => Pages\EditLibraryInformation::route('/{record}/edit'),
        ];
    }
}
