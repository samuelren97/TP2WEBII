<?php declare(strict_types=1);
session_start();
require_once('classes/user.class.php');
require_once('classes/product.class.php');
require_once('includes/connection.php');
$fileName = substr(__FILE__, strrpos(__FILE__, '\\')+1);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil | Maverick Custom Shop</title>
    <?php require_once('includes/head.php'); ?>
</head>

<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>
    <main>
        <div class="row">
            <?php
            $productDao = new ProductDao($conn);
            $productList = $productDao->getList();

            foreach($productList as $product) {
            ?>
                <div class="col-lg-6 col-md-12">
                    <img src="images/<?php echo $product->getSku() ?>.jpg">
                </div>
            <?php
            }
            ?>
        </div>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>

</html>