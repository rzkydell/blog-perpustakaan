<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Events';
    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form->schema([

            /* =======================
             |  EVENT DETAILS
             ======================= */
            Forms\Components\Section::make('Event Details')
                ->schema([
                    Forms\Components\FileUpload::make('banner')
                        ->image()
                        ->directory('event-banners')
                        ->imageEditor()
                        ->maxSize(2048)
                        ->required(fn (callable $get) => $get('status') === 'published')
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

                    Forms\Components\RichEditor::make('description')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(2),

            /* =======================
             |  EVENT INFORMATION
             ======================= */
            Forms\Components\Section::make('Event Information')
                ->schema([
                    Forms\Components\DatePicker::make('event_date')
                        ->label('Event Date')
                        ->required()
                        ->minDate(now()->toDateString()),

                    Forms\Components\TextInput::make('location')
                        ->placeholder('Campus Hall / Online / Zoom'),

                    Forms\Components\TextInput::make('registration_link')
                        ->label('Registration Link')
                        ->url()
                        ->placeholder('https://registration-link.com'),
                ])
                ->columns(2),

            /* =======================
             |  PUBLICATION
             ======================= */
            Forms\Components\Section::make('Publication')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->default('draft')
                        ->required()
                        ->disabled(fn () => Auth::user()->role !== 'admin')
                        ->rules([
                            function (callable $get) {
                                return function (string $attribute, $value, \Closure $fail) use ($get) {
                                    if ($value === 'published' && blank($get('banner'))) {
                                        $fail('Tidak dapat publish tanpa banner.');
                                    }
                                };
                            },
                        ])
                        ->live(),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Tanggal Publikasi')
                        ->visible(fn (callable $get) => $get('status') === 'published')
                        ->required(fn (callable $get) => $get('status') === 'published')
                        ->disabled(fn () => Auth::user()->role !== 'admin')
                        ->default(fn (callable $get) =>
                            $get('status') === 'published' ? now() : null
                        ),
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

                TextColumn::make('event_date')
                    ->label('Event Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('location')
                    ->limit(30),

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
            ->defaultSort('event_date', 'asc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit'   => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
