<?php
declare(strict_types=1);
require_once('classes/product.class.php');

class CartItem
{
    private $product;
    private $productQuantity;

    public function __construct(Product $product, int $productQuantity)
    {
        $this->setProductSku($product);
        $this->setProductQuantity($productQuantity);
    }

    public function getProduct()
    {
        return $this->product;
    }
    public function setProductSku(Product $product)
    {
        if ($product == null)
            throw new Exception('The product cannot be null');

        $this->product = $product;
    }

    public function getProductQuantity()
    {
        return $this->productQuantity;
    }
    public function setProductQuantity(int $quantity)
    {
        if ($quantity<0)
            throw new Exception('Quantity cannot be negative');
            
        $this->productQuantity = $quantity;
    }
}
?>