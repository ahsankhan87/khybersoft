<?php

namespace App\Models;

use CodeIgniter\Model;

class M_products extends Model
{
    protected $table = 'pos_products';
    protected $allowedFields = ['name', 'price', 'quantity', 'description', 'created_at']; // adjust fields as per your table

    public function getProducts($productID = false)
    {
        if ($productID === false) {
            return $this->findAll();
        }

        return $this->where(['id' => $productID])->first();
    }
}
