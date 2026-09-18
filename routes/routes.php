<?php

use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\GeneralController;
use App\Controllers\CatalogController;
use App\Controllers\SpecialOfferController;

//general

SimpleRouter::get('/', function() {
    $general = new GeneralController;
    $general->index();
});

SimpleRouter::get('/catalog-ajax', function() {
    $catalog = new CatalogController;
    $catalog->getCatalogItemsAjax();
});

SimpleRouter::get('/special-offers-ajax', function() {
    $specialOffer = new SpecialOfferController;
    $specialOffer->getSpecialOffersAjax();
});

SimpleRouter::get('/special-offers', function() {
    $specialOffer = new SpecialOfferController;
    $specialOffer->getSpecialOffers();
});

SimpleRouter::post('/special-offers', function() {
    $specialOffer = new SpecialOfferController;
    $specialOffer->createSpecialOffer();
});

SimpleRouter::delete('/special-offers-delete-ajax/{id}', function($id) {
    $specialOffer = new SpecialOfferController;
    $specialOffer->deleteSpecialOfferAjax($id);
});