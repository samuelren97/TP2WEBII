<?php declare(strict_types=1);

//  composer require --dev phpunit/phpunit ^10  // Commande pour installer PHPUnit.
// ./vendor/bin/phpunit tests  // Commande pour exectuer les tests.

use PHPUnit\Framework\TestCase;
require_once __DIR__."/../classes/cart.class.php";
require_once __DIR__."/../classes/user.class.php";

class CartTest extends TestCase
{
    
    public function testWithValidUserInputs(){
        $cart = new Cart(new User("alex@sam.com","allo","Darth","Vador","123 street"));
        
        $this->assertFalse($cart == null);
    }
}