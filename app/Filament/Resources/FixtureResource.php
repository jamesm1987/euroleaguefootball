<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FixtureResource\Pages;
use App\Filament\Resources\FixtureResource\RelationManagers;
use Filament\Tables\Actions\Action;
use App\Jobs\ImportApiDataJob;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\League;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Columns
use Filament\Tables\Columns\TextColumn;

// Form inputs
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class FixtureResource extends Resource
{
    protected static ?string $model = Fixture::class;

        protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
        protected static ?string $navigationGroup = 'Fixtures';
        protected static ?string $navigationLabel = 'Fixtures';
        protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hometeam.name'), 
                TextColumn::make('awayteam.name'), 
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])->headerActions([
                Action::make('Import Fixtures')
                ->action(fn ($record) => dispatch( new ImportApiDataJob('fixtures')))
                    ->requiresConfirmation()
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-on-square-stack')
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
            'index' => Pages\ListFixtures::route('/'),
            'create' => Pages\CreateFixture::route('/create'),
            'edit' => Pages\EditFixture::route('/{record}/edit'),
        ];
    }
}
