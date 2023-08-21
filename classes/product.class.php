<?php
declare(strict_types=1);
require_once('productDAO.class.php');

class Product {
    private $sku;
    private $name;
    private $description;
    private $price;
    private $stock;

    public function __construct(string $name, string $description, float $price, int $stock) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setPrice($price);
        $this->setStock($stock);
    }

    public function getSku() : int {
        return $this->sku;
    }
    public function setSku(int $sku) : void {
        if ($sku < 0)
            throw new Exception('The SKU cannot be negative');
        $this->sku = $sku;
    }

    public function getName() : string {
        return $this->name;
    }
    public function setName(string $name) : void {
        if ($name == null || empty(trim($name)))
            throw new Exception("The name cannot be null");
        $this->name = $name;
    }

    public function getDescription() : string {
        return $this->description;
    }
    public function setDescription(string $description) : void {
        if ($description == null || empty(trim($description)))
            throw new Exception("The description cannot be null");
        $this->description = $description;
    }

    public function getPrice() : float {
        return $this->price;
    }
    public function setPrice(float $price) : void {
        if ($price < 0)
            throw new Exception("The price cannot be negative");
        $this->price = $price;
    }

    public function getStock() : int {
        return $this->stock;
    }
    public function setStock(int $stock) : void {
        if ($stock < 0)
            throw new Exception('The stock cannot be negative');
        $this->stock = $stock;
    }
}
?>