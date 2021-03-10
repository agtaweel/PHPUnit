<?php

namespace App\Models;

class Order
{
    protected $products = [];
    protected $total = 0;
    public function add($product)
    {
        $this->products [] = $product;
        $this->total += $product->price();
    }

    public function products()
    {
        return $this->products;
    }

    public function total()
    {
        return $this->total;
    }
}
