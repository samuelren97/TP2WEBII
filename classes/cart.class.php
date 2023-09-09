<?php
declare(strict_types=1);
require_once('cartItem.class.php');
require_once('includes/functions.php');

class Cart
{
    private array $cartItems;
    private string $email;

    public function __construct()
    {
        $this->cartItems = array();
        $this->email = '';
    }

    public function getCartItems(): array
    {
        return $this->cartItems;
    }
    
    private function setCartItems(array $cartItems): void
    {
        if ($cartItems == null)
            throw new Exception('CartItems cannot be null');
        $this->cartItems = $cartItems;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email) : void
    {
        if ($email == null)
            throw new Exception('Email cannot be null');
        if (!isValidEmail($email))
            throw new Exception('Email must be in correct format');
        $this->email = $email;
    }

    public function addCartItem(CartItem $cartItem): void
    {
        if ($cartItem == null)
            throw new Exception('CartItem cannot be null');

        $sku = $cartItem->getProduct()->getSku();
        $indexInArray = getProductIndexInArray($sku, $this->cartItems);
        if ($indexInArray >= 0) {
            $quantity = $this->cartItems[$indexInArray]->getProductQuantity();
            $stockQuantity = $this->cartItems[$indexInArray]->getProductStock();

            if($stockQuantity-$quantity>0){
                $this->cartItems[$indexInArray]->setProductQuantity($quantity + $cartItem->getProductQuantity());
            }
        } else {
            array_push($this->cartItems, $cartItem);
        }
    }

    public function removeCartItem(int $indexInArray): void
    {
        array_splice($this->cartItems, $indexInArray, 1);
    }
}
?>