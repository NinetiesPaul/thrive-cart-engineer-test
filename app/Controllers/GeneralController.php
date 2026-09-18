<?php

namespace App\Controllers;

use App\Models\Catalog;
use App\Templates;

class GeneralController
{
    public function __construct(protected Catalog $catalogModel)
    {
    }

    public function index()
    {
        $products = $this->catalogModel->getCatalog();

        $formattedProducts = "";
        foreach ($products as $product) {
            $encodedProductData = json_encode($product);
            $formattedProducts .= "
            <p>
                <b>$product->name</b><br/>
                <small><i>$$product->price</i></small><br/>
                <a href='#' class='btn btn-sm btn-primary product' data-toggle='modal' data-target='#modalExemplo'data-product-data='$encodedProductData'>Add To Cart</a>
            <p/>";
        }

        $args = [
            'PRODUCTS' => $formattedProducts
        ];

        new Templates('index.html', $args);
    }
}
