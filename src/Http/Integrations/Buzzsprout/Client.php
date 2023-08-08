<?php

namespace ThirteenTwo\LaravelBuzzsprout\Http\Integrations\Buzzsprout;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Client
{
    private static Http $client;

    public function __construct()
    {
        self::$client = Http::withUrlParameters([
            'endpoint' => 'https://www.buzzsprout.com/api',
            'podId' => config('buzzsprout.api.podcast_id'),
        ])
            ->withHeader('Authorization', sprintf('Token token=%s', config('buzzsprout.api.key')))
            ->asJson()
            ->acceptJson();
    }

    public static final function get(string $uri, bool $withPodcastId = true): JsonResponse
    {
        $response = self::$client->get('{+endpoint}/' . ($withPodcastId ? '{+podId}' : '') . '/' . $uri);

        return new JsonResponse($response->json(), $response->status(), $response->headers(), 0, true);
    }

    public static function convertJsonToModel(string $json, string $model, bool $dataIsCollection = false): Collection|Model
    {
        $model = null;
        $collection = collect();

        return $dataIsCollection ? $collection : $model;
    }
}
