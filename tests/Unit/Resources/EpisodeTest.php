<?php

use ThirteenTwo\LaravelBuzzsprout\Http\Integrations\Buzzsprout\Client;

uses(Tests\TestCase::class);

describe('Episodes', function () {
    it('should fetch all for a given podcast', function () {
        $client = new Client();
        $results = $client::episodes();
        dd($results);
    });
});
