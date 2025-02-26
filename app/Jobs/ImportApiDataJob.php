<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Team;
use App\Models\League;
use App\Services\FootballDataService;

class ImportApiDataJob implements ShouldQueue
{
    use Queueable;

    protected $endpoint;

    /**
     * Create a new job instance.
     */
    public function __construct(string $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Execute the job.
     */
    public function handle(FootballDataService $apiService): void
    {

        match ($this->endpoint) {
            'teams' => $this->importTeams($apiService),
            'fixtures' => $this->importFixtures($apiService),
            default => logger()->warning("Unhandled API endpoint: {$this->endpoint}"),
        };
    }

    protected function importTeams($apiService)
    {
        $teamsData = [];
        
        foreach (League::pluck('api_id', 'id') as $leagueId => $apiId) {
            $response = $apiService->teams([
                'season' => config('services.football.season'),
                'league' => $apiId
            ]);

            if (!isset($response['response'])) {
                logger()->error("Invalid API response for league ID: {$leagueId}");
                continue;
            }
            
            foreach ($response['response'] as $team) {
                $teamsData[] = [
                    'api_id' => $team['team']['id'],
                    'name'   => $team['team']['name'],
                    'league_id' => $leagueId,
                ];
            }
        }

        if ( empty($teamsData) ) {
            logger()->warning('No teams found in Api responses');
            return;
        }

        foreach ($teamsData as $team) {
            
            Team::updateOrCreate(
                ['api_id' => $team['api_id']],
                [
                    'name' => $team['name'],
                    'league_id' => $team['league_id'],
                ]
            );
            
        }

        logger()->info('Successfully imported teams from API.');
    }

    protected function importFixtures($apiService)
    {
        $fixturesData = [];
        $teams = Team::pluck('id', 'api_id');
        
        foreach (League::pluck('api_id', 'id') as $leagueId => $apiId) {
            $response = $apiService->fixtures([
                'season' => config('services.football.season'),
                'league' => $apiId
            ]);

            if (!isset($response['response'])) {
                logger()->error("Invalid API response for league ID: {$leagueId}");
                continue;
            }
            
            foreach ($response['response'] as $fixture) {
                $fixturesData[] = [
                    'api_id' => $fixture['fixture']['id'],
                    'league_id' => $leagueId,
                    'home_team_id' => $teams[$fixture['fixture']['teams']['home']['id']],
                    'away_team_id' => $teams[$fixture['fixture']['teams']['away']['id']],
                    'date' => $fixture['fixture']['date'],
                ];
            }
        }

        if ( empty($fixturesData) ) {
            logger()->warning('No fixtures found in Api responses');
            return;
        }

        foreach ($fixturesData as $fixtre) {
            
            Team::updateOrCreate(
                ['api_id' => $fixture['api_id']],
                [
                    'league_id' => $fixture['league_id'],
                    'home_team_id' => $fixture['home_team_id'],
                    'away_team_id' => $fixture['away_team_id'],
                    'date' => $fixture['date'],
                ]
            );
            
        }

        logger()->info('Successfully imported fixtures from API.');
    }
}
