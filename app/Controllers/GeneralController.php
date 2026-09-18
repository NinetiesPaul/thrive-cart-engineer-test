<?php

namespace App\Controllers;

use App\DB\DB;
use App\DB\Storage\CatalogStorage;
use App\Enum;
use App\ResponseHandler;
use App\Templates;
use App\Util;

class GeneralController
{
    protected $connection;
    protected $catalogStorage;

    public function __construct()
    {
        $this->connection = new DB;
        $this->catalogStorage = new CatalogStorage();
    }

    public function index()
    {
        $products = $this->catalogStorage->getCatalog();

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
