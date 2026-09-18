<?php

namespace App\Models;

use PDO;

class Catalog
{
    protected $connector;

    public function __construct()
    {
        $this->connector = new Connector();
    }

    public function getCatalog()
    {
        $products = $this->connector->query("SELECT * FROM catalog");
        return $products->fetchAll(PDO::FETCH_OBJ);
    }
}
