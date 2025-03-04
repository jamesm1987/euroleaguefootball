<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PointRuleResource\Pages;
use App\Filament\Resources\PointRuleResource\RelationManagers;
use App\Models\PointRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Builder as BuilderInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\Builder\Block;

use Filament\Tables\Columns\TextColumn;

class PointRuleResource extends Resource
{
    protected static ?string $model = PointRule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Rule Name Input
            TextInput::make('name')
                ->label('Rule Name')
                ->required(),
    
            // Rule Description
            TextArea::make('description')
                ->label('Rule Description')
                ->required(),
    
            // Rule Scenarios Builder (each block is a full scenario with conditions and actions)
            BuilderInput::make('rule_scenarios')
                ->label('Conditions and Actions')
                ->minItems(1)
                ->maxItems(5)
                ->blocks([
                    Block::make('scenario')
                        ->label('Scenario')
                        ->schema([
                            // Conditions (Repeater to allow multiple conditions per scenario)
                            BuilderInput::make('conditions')
                                ->label('Conditions')
                                ->minItems(1)
                                ->schema([
                                    Block::make('condition')
                                        ->schema([
                                            Select::make('column_a')
                                                ->label('Column A')
                                                ->options([
                                                    'home_score' => 'Home Score',
                                                    'away_score' => 'Away Score',
                                                    'goal_difference' => 'Goal Difference',
                                                ])
                                                ->required(),
    
                                            Select::make('operator')
                                                ->label('Operator')
                                                ->options([
                                                    '>' => 'Greater Than',
                                                    '=' => 'Equal To',
                                                    '>=' => 'Greater Than or Equal To',
                                                ])
                                                ->required(),
    
                                            Select::make('column_b')
                                                ->label('Column B')
                                                ->options([
                                                    'home_score' => 'Home Score',
                                                    'away_score' => 'Away Score',
                                                    'goal_difference' => 'Goal Difference',
                                                ])
                                                ->required(),
    
                                            TextInput::make('static_value')
                                                ->label('Static Value (if needed)')
                                                ->nullable()
                                                ->numeric(),
                                        ])
                                        ->label('Condition'),
                                ]),
    
                            // Actions (Repeater to allow multiple actions per scenario)
                            BuilderInput::make('actions')
                                ->label('Actions')
                                ->minItems(1)
                                ->schema([
                                    Block::make('action')
                                        ->schema([
                                            Select::make('awarded_team')
                                                ->label('Awarded Team')
                                                ->options([
                                                    'home' => 'Home Team',
                                                    'away' => 'Away Team',
                                                ])
                                                ->required(),
    
                                            TextInput::make('points')
                                                ->label('Points Awarded')
                                                ->required()
                                                ->numeric(),
                                        ])
                                        ->label('Action'),
                                ]),
                        ]),
                ]),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description'),
                TextColumn::make('points'),
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
            'index' => Pages\ListPointRules::route('/'),
            'create' => Pages\CreatePointRule::route('/create'),
            'edit' => Pages\EditPointRule::route('/{record}/edit'),
        ];
    }
}
