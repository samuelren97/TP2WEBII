<?php
session_start();
require_once('classes/product.class.php');
require_once('includes/connection.php');
require_once('includes/functions.php');
require_once('classes/cartItem.class.php');
require_once('classes/cart.class.php');
$fileName = substr(__FILE__, strrpos(__FILE__, '\\') + 1);
$hasCartEmptyAlert = isset($_GET['cart_empty']);
$hasQuantityError = isset($_GET['quantity_err']);

if (isset($_POST['quantity'])) {
    if ($_POST['quantity'] >= 0 && $_POST['quantity'] <= $_POST['productStockQuantity']) {
        $cart = unserialize($_SESSION['cart']);
        $indexInArray = getProductIndexInArray($_POST['productSku'], $cart->getCartItems());
        if ($_POST['quantity'] == 0) {
            $cart->removeCartItem($indexInArray);
        } else {
            $cart->getCartItems()[$indexInArray]->setProductQuantity($_POST['quantity']);
        }
        
        $_SESSION['cart'] = serialize($cart);
        header('Location: cart.php');
        exit();
    }

    header('Location: cart.php?quantity_err=true');
    exit();
}

$totalPrice = 0;
$hasEmptyCart = true;

if (isset($_SESSION['cart'])) {
    $cart = unserialize($_SESSION['cart']);
    if (sizeof($cart->getCartItems()) > 0) {
        $hasEmptyCart = false;
    }
}

if (isset($_POST['order'])){
    if (!isset($_SESSION['email'])) {
        header('Location: signin.php?no_login=true');
        exit();
    }

    if ($cart != null) {
        if (sizeof($cart->getCartItems()) <= 0) {
            header('Location: cart.php?cart_empty=true');
            exit();
        }
        $cart->setEmail($_SESSION['email']);
        $_SESSION['cart'] = serialize($cart);
        $_SESSION['orderConfirmation'] = true;
        header('Location: reviewOrder.php');
        exit();
    }
    redirectToIndexAndExit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier | Maverick Custom Shop </title>
    <?php require_once('includes/head.html'); ?>
    <script defer src="js/validationCart.js"></script>
</head>

<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>
    <main class="row g-5 mt-3 mb-3 container-fluid">
        <?php if ($hasCartEmptyAlert) { ?>
            <div class="container-fluid">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span>Vous ne pouvez pas passer un panier vide en commande</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php 
        } if ($hasQuantityError) {
        ?>
            <div class="container-fluid">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span>La quantité demandée n'est pas valide</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php
        }
        ?>

        <h1>Votre Panier</h1>
        <?php

        if ($hasEmptyCart) {?>
            <div>
                Le panier est vide pour le moment.
            </div>
        <?php }

        if (isset($_SESSION['cart'])) {

            $cart = unserialize($_SESSION['cart']);
            foreach ($cart->getCartItems() as $item) {
                $product = $item->getProduct();
                $name = $product->getName();
                $description = $product->getDescription();
                $price = $product->getPrice();
                $stock = $product->getStock();
                $sku = $product->getSku();
                $quantity = $item->getProductQuantity();
                $totalPrice += $price*$quantity;
                
                ?>
                <div class="col-lg-6 col-md-12 text-center">
                    <img src="images/<?php echo $sku; ?>.png" alt="Image d'une guitare">
                </div>
                <div class="col-lg-6 col-md-12 pt-5 pb-5 border rounded">
                    <h4>
                        <?php echo $name; ?>
                    </h4>
                    <p>
                        <?php echo $description; ?>
                    </p>
                    <h5>
                        <?php echo $price; ?>$
                    </h5>

                    <form class="needs-validation" action="cart.php" method="post" novalidate>
                        <div class="row g-5">
                            <div class="col-sm-12 col-md-6">
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    name="quantity" 
                                    min='0' 
                                    value='<?php echo $quantity;?>'
                                    max="<?php echo $stock; ?>" 
                                    required>
                                <div class="invalid-feedback">
                                    La quantité demandée n'est pas valide
                                </div>
                            </div>
                                <input type="number" name="productSku" value="<?php echo $sku ?>" hidden>
                                <input type="number" name="productStockQuantity" value="<?php echo $stock; ?>" hidden>
                            <div class="col-sm-12 col-md-6">
                                <button type="submit" class="btn btn-outline-primary">Modifier le panier</button>
                            </div>
                            <p class="text-success">Quantité en stock: <?php echo $stock; ?></p>
                        </div>
                    </form>
                </div>
                <?php }}?>
        <p>
            Sous-total : <?php echo number_format($totalPrice, 2) ?> $
        </p>
        <form action="cart.php" method="post">
            <input type="text" name="order" hidden>
            <button type="submit" class="btn btn-outline-primary">Passer la commande</button>
        </form>
    </main>
    
        <?php include('includes/footer.html'); ?>
    
</body>

</html>
<?php $conn = null; ?>