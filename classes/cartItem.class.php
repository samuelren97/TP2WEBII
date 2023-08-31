<?php
declare(strict_types=1);
require_once('classes/product.class.php');

class CartItem
{
    private $product;
    private $productQuantity;

    public function __construct(Product $product, int $productQuantity)
    {
        $this->setProduct($product);
        $this->setProductQuantity($productQuantity);
    }

    public function getProduct() : Product
    {
        return $this->product;
    }
    public function setProduct(Product $product) : void
    {
        if ($product == null)
            throw new Exception('The product cannot be null');

        $this->product = $product;
    }

    public function getProductSku() : int {
        return $this->product->getSku();
    }

    public function setProductSku(int $sku) : void {
        $this->getProduct()->setSku($sku);
    }

    public function getProductStock () : int {
        return $this->getProduct()->getStock();
    }

    public function getProductQuantity() : int
    {
        return $this->productQuantity;
    }
    public function setProductQuantity(int $quantity) : void
    {
        if ($quantity<0)
            throw new Exception('Quantity cannot be negative');
            
        $this->productQuantity = $quantity;
    }
}
?>