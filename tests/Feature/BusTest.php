<?php

use Tests\TestCase;

// Test de la récupération arrêts de bus
test('Get all bus stop', function () {
    $rep = $this->getJson(route('bus'))
        ->assertSuccessful();
});
