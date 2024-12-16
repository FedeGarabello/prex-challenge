<?php

namespace App\Services;

use App\Models\GifFavorites;
use GuzzleHttp\Client;

class GifService
{
    const DEFAULT_LIMIT = 10;

    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.giphy.api_key');
        $this->baseUrl = config('services.giphy.api_base_url');
    }

    public function searchGifs($query, $limit = self::DEFAULT_LIMIT, $offset = 0)
    {
        $response = $this->client->get($this->baseUrl . 'v1/gifs/search', [
            'query' => [
                'api_key' => $this->apiKey,
                'q' => $query,
                'limit' => $limit,
                'offset' => $offset,
            ],
        ]);

        return json_decode($response->getBody());
    }

    public function getGifById($id)
    {
        $response = $this->client->get($this->baseUrl . 'v1/gifs/' . $id, [
            'query' => [
                'api_key' => $this->apiKey,
            ],
        ]);
        return json_decode($response->getBody());
    }

    public function saveGifAsFavorite($gifId)
    {
        GifFavorites::create([
            'gif_id' => $gifId,
            'user_id' => auth()->user()->id,
        ]);
    }
}
