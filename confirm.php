<?php
session_start();
require_once('classes/cart.class.php');
require_once('classes/cartDAO.class.php');
require_once('includes/connection.php');
$fileName = '';

$hasStockError = false;

if(!isset($_SESSION['checkoutConfirmation'])){
    header('Location: index.php');
    exit();
}

$cartDao = new CartDAO($conn);
$cart = unserialize($_SESSION['cart']);
unset($_SESSION['checkoutConfirmation']);
unset($_SESSION['cart']); 
if($cartDao->hasEnoughStockForCart($cart)){
    $cartDao->addOrder($cart);
    $cartDao->adjustStockQuantities($cart);
} else {
    $hasStockError=true;
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
        
        <main class="container-fluid text-center">
            <?php if ($hasStockError) { ?>
                <p class="text-danger mt-5">Inventaire non disponible depuis l'ajout au panier. Veillez ajouter des items de nouveau.</p>
            <?php } else { ?>
                <h1 class="mt-5">Merci pour votre commande</h1>
            <?php } ?>
            <a class="text-decoration-none text-white" href="index.php">
                <button class="mt-5 mb-5 btn btn-primary">
                    Continuer de magasiner
                </button>
            </a>
        </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>

</html>
