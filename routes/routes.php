<?php

use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\GeneralController;
use App\Controllers\CatalogController;
use App\Controllers\SpecialOfferController;

/** @var \App\Container $container */

//general

SimpleRouter::get('/', function () use ($container) {
    $container->get(GeneralController::class)->index();
});

SimpleRouter::get('/catalog-ajax', function () use ($container) {
    $container->get(CatalogController::class)->getCatalogItemsAjax();
});

SimpleRouter::get('/special-offers-ajax', function () use ($container) {
    $container->get(SpecialOfferController::class)->getSpecialOffersAjax();
});

SimpleRouter::get('/special-offers', function () use ($container) {
    $container->get(SpecialOfferController::class)->getSpecialOffers();
});

SimpleRouter::post('/special-offers', function () use ($container) {
    $container->get(SpecialOfferController::class)->createSpecialOffer();
});

SimpleRouter::delete('/special-offers-delete-ajax/{id}', function ($id) use ($container) {
    $container->get(SpecialOfferController::class)->deleteSpecialOfferAjax($id);
});
