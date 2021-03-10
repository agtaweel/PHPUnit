<?php

use App\Models\Product;

class ProductTest extends PHPUnit\Framework\TestCase
{
    protected $product;
    function setUp(): void
    {
        parent::setUp();
        $this->product = new Product('Fallout 4',25);
    }

    /** @test */

    function a_product_has_name()
    {
        $this->assertEquals('Fallout 4', $this->product->name());
    }
    /** @test */
    function a_product_has_price()
    {
        $this->assertEquals(25, $this->product->price());
    }
}
