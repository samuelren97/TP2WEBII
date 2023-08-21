<?php
declare(strict_types=1);

class CartItem
{
    private $productSku;
    private $productQuantity;

    public function __construct(int $productSku, int $productQuantity)
    {
        $this->setProductSku($productSku);
        $this->setProductQuantity($productQuantity);
    }

    public function getProductSku()
    {
        return $this->productSku;
    }
    public function setProductSku(int $sku)
    {
        if ($sku < 0)
            throw new Exception('Sku cannot be negative');

        $this->productSku = $sku;
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