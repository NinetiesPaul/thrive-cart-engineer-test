<?php

namespace App\Controllers;

use App\Models\Catalog;
use App\Models\SpecialOffer;
use App\ResponseHandler;
use App\Templates;

class SpecialOfferController
{
    public function __construct(
        protected Catalog $catalogModel,
        protected SpecialOffer $specialOfferModel
    ) {
    }

    public function getSpecialOffersAjax(): never
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

    public function getSpecialOffers(): void
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

    public function createSpecialOffer(): never
    {
        $data = json_decode(json_encode($_POST), true);
        $this->specialOfferModel->createSpecialOffer($data);

        header('Location: /special-offers');
        exit;
    }

    public function deleteSpecialOfferAjax($id): never
    {
        $this->specialOfferModel->deleteSpecialOffer($id);
        ResponseHandler::response();
    }
}
