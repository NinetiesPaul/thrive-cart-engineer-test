<?php

use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\GeneralController;
use App\Controllers\CatalogController;

//general

SimpleRouter::get('/', function() {
    $general = new GeneralController;
    $general->index();
});

SimpleRouter::get('/catalog', function() {
    $catalog = new CatalogController;
    $catalog->getCatalogItems();
});

SimpleRouter::get('/special-offers', function() {
    $catalog = new CatalogController;
    $catalog->getSpecialOffers();
});