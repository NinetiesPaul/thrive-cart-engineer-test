<?php

namespace App\DB\Storage;

use App\DB\DB;
use App\Enum;
use PDO;

class CatalogStorage
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getCatalog()
    {
        $products = $this->db->query("SELECT * FROM catalog");
        return $products->fetchAll(PDO::FETCH_OBJ);
    }
}
