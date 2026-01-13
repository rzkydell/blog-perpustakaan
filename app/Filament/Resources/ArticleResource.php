<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog Management';
    protected static ?string $navigationLabel = 'Articles';

    public static function form(Form $form): Form
    {
        return $form->schema([

            /* =======================
             |  MEDIA & FILE SECTION
             ======================= */
            Forms\Components\Section::make('Article Files')
                ->schema([
                    Forms\Components\FileUpload::make('banner')
                        ->image()
                        ->directory('article-banners')
                        ->imageEditor()
                        ->maxSize(2048)
                        ->required(fn (callable $get) => $get('status') === 'published')
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('pdf_file')
                        ->label('Upload Article PDF')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('article-pdfs')
                        ->maxSize(10240),

                    Forms\Components\TextInput::make('pdf_url')
                        ->label('PDF Link (Alternative)')
                        ->url()
                        ->placeholder('https://repository.example.com/article.pdf'),

                    Forms\Components\Placeholder::make('note')
                        ->content(
                            'Minimal salah satu harus diisi: file PDF atau link PDF.'
                        )
                        ->columnSpanFull(),
                ])
                ->columns(2),

            /* =======================
             |  ARTICLE CONTENT
             ======================= */
            Forms\Components\Section::make('Article Content')
                ->schema([
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

                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required(),

                    Forms\Components\Select::make('tags')
                        ->relationship('tags', 'name')
                        ->multiple()
                        ->preload(),

                    Forms\Components\RichEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
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
                                    if ($value === 'published') {
                                        if (blank($get('banner'))) {
                                            $fail('Tidak dapat publish tanpa banner.');
                                        }

                                        if (blank($get('pdf_file')) && blank($get('pdf_url'))) {
                                            $fail('Artikel harus memiliki file PDF atau link PDF.');
                                        }
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

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),

                TextColumn::make('author.name')
                    ->label('Author'),

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
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit'   => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
