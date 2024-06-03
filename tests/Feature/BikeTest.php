<?php

use Tests\TestCase;

// Test de la récupération des bike stations
test('Get All Bike', function () {
    $rep = $this->getJson(route('bike'))
        ->assertSuccessful();
});
