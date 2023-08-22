<?php declare(strict_types=1);
session_start();
require_once('classes/user.class.php');
require_once('classes/product.class.php');
require_once('includes/connection.php');
// filter_var(emailInput.textContent, FILTER_VALIDATE_EMAIL)
$fileName = substr(__FILE__, strrpos(__FILE__, '\\')+1);

// TODO: Confirm user connection
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
                        <img src="images/<?php echo $product->getSku() ?>.jpg" alt="<?php echo $product->getDescription(); ?>">
                        <p class="m-2"><?php echo $product->getDescription(); ?></p>
                        <p class="fw-bold"><?php echo $product->getPrice() . '$'; ?></p>
                    </div>
                </a>
            <?php
            }
            $conn = null;
            ?>
        </div>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>

</html>