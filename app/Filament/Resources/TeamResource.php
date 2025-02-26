<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use Filament\Tables\Actions\Action;
use App\Jobs\ImportApiDataJob;
use App\Models\Team;
use App\Models\League;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

//Actions
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use App\Filament\Exports\TeamExporter;
use Filament\Tables\Actions\ImportAction;
use App\Filament\Imports\TeamImporter;

// Columns
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

// Form inputs
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Select;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

        protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
        protected static ?string $navigationGroup = 'Teams';
        protected static ?string $navigationLabel = 'Teams';
        protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->readonly(),
                TextInput::make('display_name')->label('Display Name'),
                Select::make('league_id')
                    ->label('League')
                    ->options(League::pluck('name', 'id')),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('league.name')->badge(),
                TextColumn::make('price')->label('Price'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
            ])->headerActions([             
                ImportAction::make()
                ->importer(TeamImporter::class)->label('Import'),
                ExportAction::make()
                ->exporter(TeamExporter::class)->label('Export')
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
