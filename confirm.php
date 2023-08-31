<?php
session_start();
include_once('classes/cart.class.php');
require_once('includes/connection.php');

if(!isset($_SESSION['checkoutConfirmation'])){
    header('Location : index.php');
    exit();
}
unset($_SESSION['checkoutConfirmation']);
$cartDao = new CartDAO($conn);
$cart = unserialize($_SESSION['cart']);
if($cartDao->hasEnoughStockForCart($cart)){
    $cartDao->add($cart);
}
$conn = null; 
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation | Maverick Custom Shop</title>
    <script defer src="js/confirm.js"></script>
    <?php require_once('includes/head.php'); ?>
</head>

<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>

    <main class="container-fluid">
        <p> Merci pour votre commande ! </p>
        <button class="btn btn-outline-primary">Continuer de magasiner</button>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>

</html>
