<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use App\Models\League;
use Filament\Resources\Components\Tab; 
use Filament\Resources\Pages\ListRecords;

use Filament\Actions;
use Filament\Tables\Actions\ActionGroup;

use Filament\Tables\Actions\Action;

use App\Jobs\ImportApiDataJob;



class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Actions\CreateAction::make(),
                Action::make('Import Teams')
                ->action(fn ($record) => dispatch( new ImportApiDataJob('teams')))
                    ->requiresConfirmation()
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-on-square-stack'),
            ])

        ];
    }


    public function getTabs(): array
    {
        $tabs = ['all' => Tab::make('All')->badge($this->getModel()::count())];
 
        $leagues = League::orderBy('name', 'asc')
            ->withCount('teams')
            ->get();
 
        foreach ($leagues as $league) {
            $name = $league->name;
            $slug = str($name)->slug()->toString();
 
            $tabs[$slug] = Tab::make($name)
                ->badge($league->teams_count)
                ->modifyQueryUsing(function ($query) use ($league) {
                    return $query->where('league_id', $league->id);
                });
        }
 
        return $tabs;
    }
}
