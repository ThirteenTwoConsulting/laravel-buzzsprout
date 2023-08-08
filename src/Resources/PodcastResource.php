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
        $mainCategories = collect([$this->resource['main_category'], $this->resource['main_category2'], $this->resource['main_category3']]);
        $subCategories = collect([$this->resource['sub_category'], $this->resource['sub_category2'], $this->resource['sub_category3']]);

        $attribs = collect($this->resource)->intersectByKeys(array_flip(self::$props));
        $attribs->put('main_categories', $mainCategories);
        $attribs->put('sub_categories', $subCategories);

        return $attribs->toArray();
    }
}
