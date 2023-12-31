<?php
declare(strict_types=1);
session_start();
require_once('classes/user.class.php');
require_once('classes/product.class.php');
require_once('includes/connection.php');
require_once('classes/cart.class.php');
$fileName = substr(__FILE__, strrpos(__FILE__, '\\')+1);

$isLoginSuccess = isset($_GET['login']);
$isSignoutSuccess = isset($_GET['signout']);

if (!isset($_SESSION['cart']))
    $_SESSION['cart'] = serialize(new Cart());
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil | Maverick Custom Shop</title>
    <?php require_once('includes/head.html'); ?>
</head>

<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>

    <main class="container-fluid">
        <div class="row g-3 mt-3 mb-3">
            <?php
            $productDao = new ProductDao($conn);
            $productList = $productDao->getList();
            
            foreach($productList as $product) {
                ?>
                <a href="product.php?sku=<?php echo $product->getSku();?>" class="p-5 col-lg-6 col-md-12 text-center text-decoration-none border rounded">
                    <div>
                        <h4><?php echo $product->getName(); ?></h4>
                        <img src="images/<?php echo $product->getSku() ?>.png" alt="<?php echo $product->getDescription(); ?>">
                        <p class="fw-bold"><?php echo $product->getPrice() . '$'; ?></p>
                        <?php if ($product->getStock() == 0) { ?>
                            <p class="text-danger">Item en rupture de stock
                        <?php } ?>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        
        <?php if($isLoginSuccess) {?>
            <div class="m-5 toast show position-fixed bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success">
                    <strong class="me-auto">Succès</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    La connexion a réussi.
                </div>
            </div>
            <?php } 
        if ($isSignoutSuccess) {?>
            <div class="m-5 toast show position-fixed bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success">
                    <strong class="me-auto">Succès</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    La déconnexion a réussi.
                </div>
            </div>
            <?php } 
            ?>
            
        </main>
        
            <?php include('includes/footer.html'); ?>
        
    </body>
    
    </html>
    <?php $conn = null; ?>