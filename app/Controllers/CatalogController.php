<?php

namespace App\Controllers;

use App\Models\Catalog;
use App\ResponseHandler;

class CatalogController
{
    public function __construct(protected Catalog $catalogModel)
    {
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
