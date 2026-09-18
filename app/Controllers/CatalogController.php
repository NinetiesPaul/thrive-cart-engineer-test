<?php

namespace App\Controllers;

use App\DB\DB;
use App\DB\Storage\CatalogStorage;
use App\Enum;
use App\ResponseHandler;
use App\Templates;
use App\Util;

class CatalogController
{
    protected $connection;
    protected $catalogStorage;

    public function __construct()
    {
        $this->connection = new DB;
        $this->catalogStorage = new CatalogStorage();
    }

    public function getCatalogItems()
    {
        $products = $this->catalogStorage->getCatalog();

        ResponseHandler::response($products);
    }

    public function getSpecialOffers()
    {
        $specialOffers = [
            "R01" => [
                "onEveryNItems" => 2,
                "discountRate" => 0.5,
            ]
        ];

        ResponseHandler::response($specialOffers);
    }
}
