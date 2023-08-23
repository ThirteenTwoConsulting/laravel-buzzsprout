<?php

namespace ThirteenTwo\LaravelBuzzsprout\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EpisodeResource extends JsonResource
{
    private static $props = [
        'id',
        'title',
        'audio_url',
        'artwork_url',
        'description',
        'summary',
        'artist',
        'tags',
        'published_at',
        'duration',
        'hq',
        'magic_mastering',
        'guid',
        'inactive_at',
        'episode_number',
        'season_number',
        'explicit',
        'private',
        'total_plays',
        'episode_type'
    ];

    public function toArray(Request $request)
    {
        return collect(json_decode($this->resource, true))->intersectByKeys(array_flip(self::$props))->toArray();
    }
}
