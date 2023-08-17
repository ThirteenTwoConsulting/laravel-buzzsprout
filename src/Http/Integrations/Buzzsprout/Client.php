<?php

namespace ThirteenTwo\LaravelBuzzsprout\Http\Integrations\Buzzsprout;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use ThirteenTwo\LaravelBuzzsprout\Resources\Collections\EpisodeCollection;
use ThirteenTwo\LaravelBuzzsprout\Resources\EpisodeResource;
use ThirteenTwo\LaravelBuzzsprout\Resources\PodcastResource;

class Client
{
    private static PendingRequest $client;

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

    public static final function podcast(): PodcastResource
    {
        return PodcastResource::make(
            self::get('/podcasts', false)->content()
        );
    }

    public static final function episodes(): EpisodeCollection
    {
        $data = json_decode(self::get('/episodes')->content(), true);

        $episodes = collect();

        foreach ($data as $episode) {
            $episodes->push(EpisodeResource::make(json_encode($episode)));
        }

        return EpisodeCollection::make($episodes);
    }

    public static final function episode(int $episodeId): EpisodeResource
    {
        return EpisodeResource::make(self::get('/episodes/' . $episodeId)->content());
    }

    private static function get(string $uri, bool $withPodcastId = true): JsonResponse
    {
        $response = self::$client->get('{+endpoint}/' . ($withPodcastId ? '{+podId}' : '') . '/' . $uri . '.json');

        return JsonResponse::fromJsonString($response->body(), $response->status(), $response->headers());
    }
}
