<?php

use Tests\TestCase;

// Test de tous les arrêts de tram
test('Get all tram stop', function () {
    $rep = $this->getJson(route('tram'))
        ->assertSuccessful();
});

// Test de la récupération des lignes de trams
test('Get all tram line', function () {
    $rep = $this->getJson(route('tram-coordinates'))
        ->assertSuccessful();
});
