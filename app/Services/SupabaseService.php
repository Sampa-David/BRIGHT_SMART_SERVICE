<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class SupabaseService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('SUPABASE_URL');
        $this->apiKey = env('SUPABASE_KEY');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'apikey' => $this->apiKey,
                'Authorization' => 'Bearer ' . $this->apiKey,
            ]
        ]);
    }

    public function getUser($token)
    {
        try {
            $response = $this->client->get('/auth/v1/user', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);
            return json_decode($response->getBody());
        } catch (\Exception $e) {
            return null;
        }
    }

    public function query($table, $select = '*', $filters = [])
    {
        try {
            $queryParams = ['select' => $select];
            if (!empty($filters)) {
                foreach ($filters as $key => $value) {
                    $queryParams[$key] = $value;
                }
            }

            $response = $this->client->get('/rest/v1/' . $table, [
                'query' => $queryParams
            ]);

            return json_decode($response->getBody());
        } catch (\Exception $e) {
            return null;
        }
    }
}