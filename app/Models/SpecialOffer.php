<?php

namespace App\Models;

use PDO;

class SpecialOffer
{
    public function __construct(protected Connector $connector)
    {
    }

    public function getSpecialOffers()
    {
        $specialOffers = $this->connector->query("SELECT c.code, so.discountRate, so.onEveryNItems, so.id  FROM special_offers so JOIN catalog c ON so.catalog_id = c.id");
        return $specialOffers->fetchAll(PDO::FETCH_OBJ);
    }

    public function getSpecialOfferByCode($code)
    {
        $specialOffer = $this->connector->query("SELECT so.id, c.code, so.discountRate, so.onEveryNItems  FROM special_offers so JOIN catalog c ON so.catalog_id = c.id WHERE so.catalog_id = $code");
        return $specialOffer->fetch(PDO::FETCH_OBJ);
    }

    public function createSpecialOffer($data)
    {
        $specialOffer = $this->getSpecialOfferByCode($data['code']);
        if ($specialOffer) {
            $this->deleteSpecialOffer($specialOffer->id);
        }

        $specialOfferQuery = $this->connector->prepare("
            INSERT INTO special_offers (catalog_id, onEveryNItems, discountRate) VALUES (:catalog_id, :onEveryNItems, :discountRate)
        ");

        $specialOfferQuery->execute([
            'catalog_id' => $data['code'],
            'onEveryNItems' => $data['onEveryNItems'],
            'discountRate' => $data['discountRate']
        ]);
    }

    public function deleteSpecialOffer($id)
    {
        $specialOfferQuery = $this->connector->prepare("DELETE FROM special_offers WHERE id = :id");
        $specialOfferQuery->execute([
            'id' => $id
        ]);
    }
}
