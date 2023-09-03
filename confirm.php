<?php
session_start();
require_once('classes/cart.class.php');
require_once('classes/cartDAO.class.php');
require_once('includes/connection.php');
$fileName = '';

if(!isset($_SESSION['checkoutConfirmation'])){
    header('Location: index.php');
    exit();
}

$cartDao = new CartDAO($conn);
$cart = unserialize($_SESSION['cart']);
unset($_SESSION['checkoutConfirmation']);
unset($_SESSION['cart']); // Reinitialize le cart un fois la commande confirmee et ajuste les products stock dans la $_SESSION['cart'] provenant de la BD a jour)
if($cartDao->hasEnoughStockForCart($cart)){
    $cartDao->addOrder($cart);
    $cartDao->adjustStockQuantities($cart);
}
else{
    echo "Inventaire insuffisant depuis l'ajout au panier. 
    Veillez svp ajouter vos items de nouveau, les quantitee en stock sont maintenant a jour."; //TODO: affichage erreur conflit d'inventaire
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
        <form action="confirm.php">
            <button class="btn btn-outline-primary">Continuer de magasiner</button>
        </form>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>

</html>
