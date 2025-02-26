<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FootballDataService
{

    protected $apiKey;
    protected $season;
    protected $baseUrl;
    protected $host;

    public function __construct()
    {
        $this->apiKey = config('services.football.api_key');
        $this->season = config('services.football.season');
        $this->baseUrl = config('services.football.base_url');
        $this->host = config('services.football.host');
    }

    public function teams(array $params = [])
    {
        return $this->fetch('teams', $params);
    }

    public function fixtures(array $params = [])
    {
        return $this->fetch('fixtures', $params);
    }


    protected function fetch(string $endpoint, array $params = []) 
    {

        try {
            $url = "{$this->baseUrl}{$endpoint}";
            
            $response = Http::withHeaders([
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->apiKey,
            ])->get($url, $params);

            if ($response->failed()) {
                logger()->error("API call failed for {$url}", ['response' => $response->body()]);
                return null;
            }

            return $response->json();
        
        } catch (\Exception $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return null;
        }
    }
}