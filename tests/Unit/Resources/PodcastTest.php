<?php

use Illuminate\Http\Request;
use ThirteenTwo\LaravelBuzzsprout\Resources\Collections\PodcastCollection;
use ThirteenTwo\LaravelBuzzsprout\Resources\PodcastResource as Podcast;

describe('Resources', function () {
  describe('Podcast', function () {
    it('populates Podcast resource', function () {
      $json = '{
   "id": 10,
   "title": "Life Empowerment",
   "author": "Motivational Mike",
   "description": "Let me tell you how to live your best life today!",
   "website_address": null,
   "contact_email": "team+mike@buzzsprout.com",
   "keywords": null,
   "explicit": false,
   "main_category": null,
   "sub_category": null,
   "main_category2": null,
   "sub_category2": null,
   "main_category3": null,
   "sub_category3": null,
   "language": "en-us",
   "timezone": "Eastern Time (US \u0026 Canada)",
   "artwork_url": "http://www.buzzsprout.test/images/artworks_large.jpg",
   "background_url": null
 }';

      $podcast = Podcast::make(json_decode($json, true))->resolve(new Request());

      expect($podcast)->id->toBe(10);
      expect(count($podcast['main_categories']))->toBe(3);
      expect(count($podcast['sub_categories']))->toBe(3);
      expect($podcast)->explicit->toBeFalse();
      expect($podcast)->title->toBe('Life Empowerment');
      expect($podcast)->author->toBe('Motivational Mike');
    });
  });

  describe('Collections', function () {
    describe('Podcast', function () {
      it('populates a collection of multiple podcasts', function () {
        $json = '[
 {
   "id": 10,
   "title": "Life Empowerment",
   "author": "Motivational Mike",
   "description": "Let me tell you how to live your best life today!",
   "website_address": null,
   "contact_email": "team+mike@buzzsprout.com",
   "keywords": null,
   "explicit": false,
   "main_category": null,
   "sub_category": null,
   "main_category2": null,
   "sub_category2": null,
   "main_category3": null,
   "sub_category3": null,
   "language": "en-us",
   "timezone": "Eastern Time (US \u0026 Canada)",
   "artwork_url": "http://www.buzzsprout.test/images/artworks_large.jpg",
   "background_url": null
 },
 {
   "id": 20,
   "title": "Youth Podcast",
   "author": "Pastor Tim Tom",
   "description": "Our super cool youth podcast",
   "website_address": null,
   "contact_email": "team+tim@buzzsprout.com",
   "keywords": null,
   "explicit": false,
   "main_category": null,
   "sub_category": null,
   "main_category2": null,
   "sub_category2": null,
   "main_category3": null,
   "sub_category3": null,
   "language": "en-us",
   "timezone": "Eastern Time (US \u0026 Canada)",
   "artwork_url": "http://www.buzzsprout.test/images/artworks_large.jpg",
   "background_url": null
 }
]';
        $data = json_decode($json, true);
        $collect = collect();

        foreach ($data as $podcastData) {
          $collect->push(Podcast::make($podcastData));
        }

        $podcastCollection = PodcastCollection::make($collect);

        expect($podcastCollection->count())->toBe(2);
        expect($podcastCollection->filter(fn ($obj) => $obj['id'] == 20))->not->toBeEmpty();
      });
    });
  });
});
