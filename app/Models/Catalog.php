<?php

namespace App\Models;

use PDO;

class Catalog
{
    public function __construct(protected Connector $connector)
    {
    }

    public function getCatalog(): array
    {
        $products = $this->connector->query("SELECT * FROM catalog");
        return $products->fetchAll(PDO::FETCH_OBJ);
    }
}
