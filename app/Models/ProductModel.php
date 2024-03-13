<?php 

namespace App\Models;

use App\core\DB;

class ProductModel
{
    public function getProduct()
    {
        $data = array('nombre' => 'John', 'edad' => 25, 'id' => 12);
        return $data;
    }
}