<?php

namespace App\Controllers;

use App\Models\Catalog;
use App\ResponseHandler;
use App\Templates;
use App\Util;

class CatalogController
{
    protected $catalogModel;

    public function __construct()
    {
        $this->catalogModel = new Catalog();
    }

    public function getCatalogItemsAjax()
    {
        $products = $this->catalogModel->getCatalog();

        $productsData = [];
        foreach ($products as $product) {
            $productsData[$product->code] = $product;
        }

        ResponseHandler::response($productsData);
    }
}
