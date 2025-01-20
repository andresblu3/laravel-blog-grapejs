<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Entradas del Blog';

    protected static ?string $modelLabel = 'Entrada';

    protected static ?string $pluralModelLabel = 'Entradas';

    public static function canViewAny(): bool
    {
        return Auth::check() && (
            Auth::user()->hasRole('admin') || 
            Auth::user()->hasRole('designer')
        );
    }

    public static function canCreate(): bool
    {
        return Auth::check() && Auth::user()->hasAnyRole(['admin', 'designer']);
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::check() && (
            Auth::user()->hasRole('admin') ||
            (Auth::user()->hasRole('designer') && $record->author_id === Auth::id())
        );
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::check() && (
            Auth::user()->hasRole('admin') ||
            (Auth::user()->hasRole('designer') && $record->author_id === Auth::id())
        );
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contenido Principal')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('URL Amigable')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\View::make('filament.forms.components.editor-button')
                            ->visible(fn (?Model $record) => $record !== null),
                        Forms\Components\Textarea::make('excerpt')
                            ->label('Extracto')
                            ->rows(3),
                    ])->columns(1),
                Forms\Components\Section::make('Publicación')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publicar')
                            ->default(false),
                        DateTimePicker::make('published_at')
                            ->label('Fecha de Publicación')
                            ->default(now()),
                        Hidden::make('author_id')
                            ->default(Auth::id()),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Autor')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_published')
                    ->label('Publicado')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Fecha de Publicación')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Estado de Publicación')
                    ->placeholder('Todos')
                    ->trueLabel('Publicados')
                    ->falseLabel('Borradores'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
