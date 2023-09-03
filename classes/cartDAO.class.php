<?php

declare(strict_types=1);

class CartDAO
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

    public function hasEnoughStockForCart(Cart $cart): bool
    {
        foreach ($cart->getCartItems() as $item) {
            $quantity = $item->getProductQuantity();

            $req = $this->db->prepare('SELECT stock FROM products WHERE sku = :sku');
            $req->bindValue(':sku',  $item->getProductSku(), PDO::PARAM_INT);
            $req->execute();

            $line = $req->fetch(PDO::FETCH_ASSOC);
            $qtyInStock = $line['stock'];
            if ($qtyInStock < $quantity) {
                return false;
            }
            $req->closeCursor();
        }
        return true;
    }
    public function addOrder(Cart $cart): void
    {
        $req = $this->db->prepare('INSERT INTO orders(user_id, creation_date) VALUES(
            (SELECT id FROM users WHERE email=:email), NOW())');
        $req->bindValue(':email', $cart->getEmail(), PDO::PARAM_STR);
        $req->execute();
        $orderId = $this->db->lastInsertId();

        foreach ($cart->getCartItems() as $cartItem) {
            $req = $this->db->prepare('INSERT INTO order_items(order_id,product_sku,quantity)
                VALUES (:order_id, :product_sku, :quantity)');

            $req->bindValue(':order_id', $orderId, PDO::PARAM_INT);
            $req->bindValue(':product_sku', $cartItem->getProductSku(), PDO::PARAM_INT);
            $req->bindValue(':quantity', $cartItem->getProductQuantity(), PDO::PARAM_INT);
            $req->execute();
        }
        $req->closeCursor();
    }

    public function adjustStockQuantities(Cart $cart): void
    {
        foreach ($cart->getCartItems() as $item) {
            
            $qtyOrdered = $item->getProductQuantity();

            $req = $this->db->prepare('SELECT stock FROM products WHERE sku = :sku');
            $req->bindValue(':sku',  $item->getProductSku(), PDO::PARAM_INT);
            $req->execute();

            if($line = $req->fetch(PDO::FETCH_ASSOC)){
                $qtyInStock = $line['stock'];
                $newStockQty = $qtyInStock - $qtyOrdered;
                $req->closeCursor();
                
                $req = $this->db->prepare('UPDATE products SET stock = :stock WHERE sku = :sku');
                $req->bindValue(':stock', $newStockQty, PDO::PARAM_INT);
                $req->bindValue(':sku', $item->getProductSku(), PDO::PARAM_INT);
                $req->execute();
            }
            $req->closeCursor();
        }
    }
}
