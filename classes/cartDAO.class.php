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

    
    public function add(Cart $cart): void
    {
        $req = $this->db->prepare('INSERT INTO orders(user_id, creation_date) VALUES(:user_id, NOW())');
        $req->bindValue(':user_id', $cart->getUserId(), PDO::PARAM_INT);
        $req->execute();
        $orderId = $this -> db->lastInsertId();

        foreach($cart->getCartItems() as $cartItem) {
            $req = $this->db->prepare('INSERT INTO order_items(order_id,product_sku,quantity)
                VALUES (:order_id, :product_sku, :quantity)');

                
            $req->bindValue(':order_id', $orderId, PDO::PARAM_INT);
            $req->bindValue(':product_sku', $cartItem->getProductSku(), PDO::PARAM_INT);
            $req->bindValue(':quantity', $cartItem->getQuantity(), PDO::PARAM_INT);
            $req->execute();
        }
        
        $req->closeCursor();
    }
}
?>