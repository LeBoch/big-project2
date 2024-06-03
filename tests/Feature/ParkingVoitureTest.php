<?php
// Test de la route de la récupération des parkings de voitures
test('Get all Parking', function () {
    $rep = $this->getJson(route('car'))
        ->assertSuccessful();
});


