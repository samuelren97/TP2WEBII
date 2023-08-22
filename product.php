<?php
require_once('classes/product.class.php');
require_once('includes/connection.php');
require_once('includes/functions.php');
$fileName = '';

if (isset($_GET['sku'])) {
    $sku =  $_GET['sku'];
    $productDao = new ProductDao($conn);

    $product = $productDao->get($sku);
    if ($product == null)
        redirectToIndexAndExit();
} else {
    redirectToIndexAndExit();
}

$name = $product->getName();
$description = $product->getDescription();
$price = $product->getPrice();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name . " | Maverick Custom Shop" ?></title>
    <?php require_once('includes/head.php'); ?>
</head>
<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>
    <main class="row g-5 mt-3 mb-3">
        <div class="col-lg-6 col-md-12 text-center">
            <img src="images/<?php echo $sku;?>.jpg" alt="Image d'une guitare">
        </div>
        <div class="col-lg-6 col-md-12 pt-5 pb-5 border rounded">
            <h4><?php echo $name; ?></h4>
            <p><?php echo $description; ?></p>
            <h5><?php echo $price; ?>$</h5>

            <form action="#" method="post"> <!-- TODO: Set action -->
                <div class="row g-5">
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="quantity" name="quantity" min='0' value='1' required>
                    </div>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-primary value="Ajouter au panier">
                    </div>
                </div>
            </form>

        </div>
        <?php
        $conn = null;
        ?>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>
</html>