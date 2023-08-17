<?php

namespace ThirteenTwo\LaravelBuzzsprout\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PodcastResource extends JsonResource
{
    private static $props = [
        'id',
        'title',
        'author',
        'description',
        'website_address',
        'contact_email',
        'keywords',
        'explicit',
        'main_categories',
        'sub_categories',
        'language',
        'timezone',
        'artwork_url',
        'background_url'
    ];

    public function toArray(Request $request)
    {
        $data = json_decode($this->resource, true)[0];

        $mainCategories = collect([$data['main_category'], $data['main_category2'], $data['main_category3']]);
        $subCategories = collect([$data['sub_category'], $data['sub_category2'], $data['sub_category3']]);

        $attribs = collect($data)->intersectByKeys(array_flip(self::$props));
        $attribs->put('main_categories', $mainCategories);
        $attribs->put('sub_categories', $subCategories);

        return $attribs->toArray();
    }
}
