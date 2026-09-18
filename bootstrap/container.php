<?php

use App\Container;
use App\Controllers\CatalogController;
use App\Controllers\GeneralController;
use App\Controllers\SpecialOfferController;
use App\Models\Catalog;
use App\Models\Connector;
use App\Models\SpecialOffer;

$container = new Container();

$container->singleton(Connector::class, function () {
    return new Connector();
});

$container->singleton(Catalog::class, function (Container $container) {
    return new Catalog($container->get(Connector::class));
});

$container->singleton(SpecialOffer::class, function (Container $container) {
    return new SpecialOffer($container->get(Connector::class));
});

$container->singleton(GeneralController::class, function (Container $container) {
    return new GeneralController($container->get(Catalog::class));
});

$container->singleton(CatalogController::class, function (Container $container) {
    return new CatalogController($container->get(Catalog::class));
});

$container->singleton(SpecialOfferController::class, function (Container $container) {
    return new SpecialOfferController(
        $container->get(Catalog::class),
        $container->get(SpecialOffer::class)
    );
});

return $container;
