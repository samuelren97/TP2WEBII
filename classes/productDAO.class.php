<?php
declare(strict_types=1);

class ProductDao
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    public function setDb(PDO $db)
    {
        $this->db = $db;
    }

    public function get(int $sku): ?Product
    {
        if ($sku < 0)
            throw new Exception('The SKU cannot be negative');

        $product = null;
        $req = $this->db->prepare('SELECT * FROM products WHERE sku = :sku');
        $req->bindValue(':sku', $sku, PDO::PARAM_INT);
        $req->execute();

        if ($line = $req->fetch(PDO::FETCH_ASSOC)){
            $product = new Product($line['name'], $line['description'], (float)$line['price'], (int)$line['stock']);
            $product->setSku($sku);
        }

        $req->closeCursor();

        return $product;
    }
    public function getList(): array
    {
        $req = $this->db->prepare('SELECT * FROM products ORDER BY RAND()');
        
        $req->execute();

        
        $products = array();
        while($line = $req->fetch(PDO::FETCH_ASSOC))
        {
            $product = new Product($line['name'], $line['description'], (float)$line['price'], (int)$line['stock']);
            $product->setSku($line['sku']);
            array_push($products, $product);
        }

        $req->closeCursor();

        return $products;
    }

    public function update(Product $product): void
    {
        if ($product == null)
            throw new Exception('Product cannot be null');

        $req = $this->db->prepare('UPDATE products SET stock = :stock WHERE sku = :sku');

        $req->bindValue(':sku', $product->getSku(), PDO::PARAM_INT);

        $req->execute();

        $req->closeCursor();
    }
}