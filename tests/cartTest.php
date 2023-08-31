<?php declare(strict_types=1);

//  composer require --dev phpunit/phpunit ^10  // Commande pour installer PHPUnit.
// ./vendor/bin/phpunit tests  // Commande pour exectuer les tests.

use PHPUnit\Framework\TestCase;
require_once __DIR__."/../classes/cart.class.php";
require_once __DIR__."/../classes/user.class.php";
require_once __DIR__."/../classes/product.class.php";
require_once __DIR__."/../classes/cartItem.class.php";

class CartTest extends TestCase
{
    
    public function testCartConstructor() : void {
        $cart = new Cart();
        $EXPECTED = '';
        
        $this->assertFalse($cart == null);
        $this->assertEquals($EXPECTED, $cart->getEmail());
    }
    
    public function testCartAddItem() : void {
        $EXPECTED = 1;
        $cart = new Cart();
        $product1 = new Product("NAME","DESCRIPTION",10.5,3);
        $product1->setSku(123);
        $item = new CartItem($product1,1);

        $cart->addCartItem($item);

        $this->assertEquals($EXPECTED,sizeof($cart->getCartItems()));
    }

    public function testCartAddSameItems() : void {
        $EXPECTED = 1;
        $cart = new Cart();
        $product1 = new Product("NAME","DESCRIPTION",10.5,3);
        $product2 = new Product("NAME","DESCRIPTION",10.5,3);
        $product1->setSku(123);
        $product2->setSku(123);

        $item1 = new CartItem($product1,1);
        $item2 = new CartItem($product2,1);

        $cart->addCartItem($item1);
        $cart->addCartItem($item2);

        $this->assertEquals($EXPECTED,sizeof($cart->getCartItems()));
    }

    public function testCartAddDifferentItems() : void {
        $EXPECTED = 2;
        $cart = new Cart();
        $product1 = new Product("NAME","DESCRIPTION",10.5,3);
        $product2 = new Product("NAME","DESCRIPTION",10.5,3);
        $product1->setSku(123);
        $product2->setSku(666);

        $item1 = new CartItem($product1,1);
        $item2 = new CartItem($product2,1);

        $cart->addCartItem($item1);
        $cart->addCartItem($item2);

        $this->assertEquals($EXPECTED,sizeof($cart->getCartItems()));
    }

    public function testCartRemoveItems() : void {
        $EXPECTED = 1;
        $product1Sku=123;
        $product2Sku=666;
        $cart = new Cart();
        $product1 = new Product("NAME","DESCRIPTION",10.5,3);
        $product2 = new Product("NAME","DESCRIPTION",10.5,3);
        $product1->setSku($product1Sku);
        $product2->setSku($product2Sku);

        $item1 = new CartItem($product1,1);
        $item2 = new CartItem($product2,1);

        $cart->addCartItem($item1);
        $cart->addCartItem($item2);
        $cart->removeCartItem(0);

        $this->assertEquals($EXPECTED,sizeof($cart->getCartItems()));
        $this->assertEquals($product2Sku, $cart->getCartItems()[0]->getProductSku());
    }

    
}