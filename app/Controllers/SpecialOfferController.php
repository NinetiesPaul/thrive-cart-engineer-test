<?php

namespace App\Controllers;

use App\Models\Catalog;
use App\Models\SpecialOffer;
use App\ResponseHandler;
use App\Templates;
use App\Util;

class SpecialOfferController
{
    protected $catalogModel;
    protected $specialOfferModel;

    public function __construct()
    {
        $this->catalogModel = new Catalog();
        $this->specialOfferModel = new SpecialOffer();
    }

    public function getSpecialOffersAjax()
    {
        $specialOffers = $this->specialOfferModel->getSpecialOffers();

        $specialOffersData = [];
        foreach ($specialOffers as $specialOffer) {
            $specialOffersData[$specialOffer->code] = [
                "onEveryNItems" => $specialOffer->onEveryNItems,
                "discountRate" => $specialOffer->discountRate,
            ];
        }

        ResponseHandler::response($specialOffersData);
    }

    public function getSpecialOffers()
    {
        $specialOffers = $this->specialOfferModel->getSpecialOffers();

        $formattedSpecialOffers = "";
        foreach ($specialOffers as $specialOffer) {
            $discountRate = $specialOffer->discountRate * 100;
            $formattedSpecialOffers .= "
                <p>
                    $discountRate% off on every $specialOffer->onEveryNItems $specialOffer->code <a href='#' class='btn btn-sm btn-danger delete-special-offer' data-id='$specialOffer->id'>Remove Offer</a>
                </p>
            ";
        }

        $products = $this->catalogModel->getCatalog();

        $formattedProducts = "";
        foreach ($products as $product) {
            $encodedProductData = json_encode($product);
            $formattedProducts .= "
                <option value='$product->id'>$product->name ($product->code)</option>
            ";
        }

        $args = [
            'PRODUCTS' => $formattedProducts,
            'SPECIAL_OFFERS' => $formattedSpecialOffers
        ];

        new Templates('special-offers.html', $args);
    }

    public function createSpecialOffer()
    {
        $data = json_decode(json_encode($_POST), true);
        $this->specialOfferModel->createSpecialOffer($data);

        header('Location: /special-offers');
        exit;
    }

    public function deleteSpecialOfferAjax($id)
    {
        $this->specialOfferModel->deleteSpecialOfferAjax($id);
        ResponseHandler::response();
    }
}
