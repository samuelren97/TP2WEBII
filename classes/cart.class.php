<?php
declare(strict_types=1);
require_once('cartItem.class.php');

class Cart
{
    private $cartItems;
    private $email;

    public function __construct(string $email)
    {
        $this->setEmail($email);
        $this->setCartItems(array());
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

    // TODO: Add function to get email -> DONE
    public function getEmail(): string
    {
        return $this->email;
    }

    private function setEmail(string $email)
    {
        if ($email == null)
            throw new Exception('User cannot be null');
        $this->email = $email;
    }

    public function addCartItem(CartItem $cartItem): void
    {
        if ($cartItem == null)
            throw new Exception('CartItem cannot be null');
        // FIXME: Verify if item already in cart, if so, add quantity
        array_push($this->cartItems, $cartItem);
    }

    // TODO: Add quantity

    public function removeCartItem(CartItem $cartItem): void
    {
        if ($cartItem == null)
            throw new Exception('CartItem cannot be null');

            if ($index = array_search($cartItem, $this->cartItems)) {
                unset($cartItems[$index]);
            }

    }

    // TODO: Remove quantity
}
?>