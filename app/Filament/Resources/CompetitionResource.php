<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetitionResource\Pages;
use App\Filament\Resources\CompetitionResource\RelationManagers;
use App\Models\Competition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


// Columns
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Parfaitementweb\FilamentCountryField\Tables\Columns\CountryColumn;

// Form inputs
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;


class CompetitionLeagueResource extends Resource
{
    protected static ?string $model = League::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Competitions';
    protected static ?string $navigationLabel = 'Competitions';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Country::make('country')
                    ->map(['GB' => 'UK']),
                TextInput::make('api_id')->label('API ID'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                CountryColumn::make('country'),
                TextColumn::make('teams_count')
                ->counts('teams')
                ->badge(),
                TextColumn::make('api_id')->label('API ID'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCompetitions::route('/'),
            'create' => Pages\CreateCompetition::route('/create'),
            'edit' => Pages\EditCompetition::route('/{record}/edit'),
        ];
    }
}
