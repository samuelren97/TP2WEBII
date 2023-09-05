<?php
session_start();

const TAX_DECIMAL_POINTS = 2;
const TAXES_RATE = 1.14975;

require_once('classes/cart.class.php');
require_once('includes/connection.php');
require_once('classes/user.class.php');

if(isset($_POST['checkoutConfirmation'])){
    $_SESSION['checkoutConfirmation'] = true;
    header('Location: confirm.php');
    exit();
}

if(!isset($_SESSION['orderConfirmation'])){
    header('Location: index.php');
    exit();
}
unset($_SESSION['orderConfirmation']);


$userDao = new UserDAO($conn);
$user = $userDao->getUserWithEmail($_SESSION['email']);

$cart = unserialize($_SESSION['cart']);
$totalPrice=0;

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revoir la commande | Maverick Custom Shop </title>
    <?php require_once('includes/head.html'); ?>
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/reviewOrder.js"></script>
</head>

<body>
    <header class="bg-primary pl-5 pt-3 pb-3 container-fluid">
        <h1 class="text-white">Facture</h1>
    </header>
    <main class="mt-3 mb-3 container-fluid">
<h2>Vos items:</h2>
        <?php
        
            foreach ($cart->getCartItems() as $item) {
                $product = $item->getProduct();
                $name = $product->getName();
                $price = $product->getPrice();
                $stock = $product->getStock();
                $sku = $product->getSku();
                $quantity = $item->getProductQuantity();
                $totalItemPrice = $price*$quantity;
                $totalPrice += $totalItemPrice;
                
        ?>
                <div class="d-flex justify-content-between mt-3 mb-3 ps-5 pe-5 pt-5 border border-2 rounded">
                    <div class="row">
                        <div class="col-sm-6 larger">
                            <img src="images/<?php echo $sku;?>_small.png" alt="Image d'une guitare.">
                        </div>
                        <div class="col-sm-6">
                            <p>
                                <?php echo $name; ?>
                                <span class="bold"><?php echo' x' . $quantity;?></span>
                            </p>
                        </div>
                    </div>
                    <p class="bold"><?php echo $totalItemPrice;?>$</p>
                </div>
            <?php }
            ?>
            <hr><h2>Vos informations:</h2>
            
            <div>
                <p class="infoTitle">Prénom : </p>
                <p class="infoData"><?php echo $user->getFirstName(); ?></p>
                
            </div>
            <div>
                <p class="infoTitle">Nom : </p>
                <p class="infoData"><?php echo $user->getLastName(); ?></p>
                
            </div>
            <div>
                <p class="infoTitle">Addresse : </p>
                <p class="infoData"><?php echo $user->getShippingAddress(); ?></p>
            </div>

            
        <hr><p class='bold fs-2'>
            Total :  <?php echo number_format($totalPrice*TAXES_RATE, TAX_DECIMAL_POINTS) ?> $ taxes incluses
        </p>

        <div id="btnDiv">
            <form action="reviewOrder.php" method="post">
                <input type="text" name="checkoutConfirmation" hidden>
                <button type="submit" class="btn btn-primary">Passer la commande</button>
            </form>
            <button class="btn btn-outline-primary">Retour au panier</button>
        </div>
    </main>
    
        <?php include('includes/footer.html'); ?>
    
</body>

</html>
<?php $conn = null; ?>