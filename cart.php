<?php
session_start();
require_once('classes/product.class.php');
require_once('includes/connection.php');
require_once('includes/functions.php');
require_once('classes/cartItem.class.php');
$fileName = substr(__FILE__, strrpos(__FILE__, '\\') + 1);

if (isset($_POST['quantity'])) {
    $cartItems = array();
    $cartItems = unserialize($_SESSION['cartItems']);
    $indexInArray = getProductIndexInArray($_POST['productSku'], $cartItems);
    // TODO: Validate quantity
    if ($_POST['quantity'] == 0) {
        array_splice($cartItems, $indexInArray, 1);
    } else {
        $cartItems[$indexInArray]->setProductQuantity($_POST['quantity']);
    }

    $_SESSION['cartItems'] = serialize($cartItems);
    header('Location: cart.php');
    exit();
}

// TODO: Check if cart is set

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Maverick Custom Shop </title>
    <?php require_once('includes/head.php'); ?>
</head>

<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>
    <main class="row g-5 mt-3 mb-3 container-fluid">
        <h1>Votre Panier</h1>

        <?php
        if (isset($_SESSION['cartItems'])) {

            $totalPrice = 0;
            $cartItems = unserialize($_SESSION['cartItems']);
            foreach ($cartItems as $item) {
                $product = $item->getProduct();
                $name = $product->getName();
                $description = $product->getDescription();
                $price = $product->getPrice();
                $stock = $product->getStock();
                $sku = $product->getSku();
                $quantity = $item->getProductQuantity();
                $totalPrice += $price;
                
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

                    <form action="cart.php" method="post">
                        <div class="row g-5">
                            <div class="col-sm-12 col-md-6">
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    id="quantity" 
                                    name="quantity" 
                                    min='0' 
                                    value='<?php echo $quantity;?>'
                                    max="<?php echo $stock; ?>" 
                                    required>
                            </div>
                                <input type="number" name="productSku" value="<?php echo $sku ?>" hidden>
                            <div class="col-sm-12 col-md-6">
                                <button type="submit" class="btn btn-outline-primary">Modifier le panier</button>
                            </div>
                            <p class="text-success">Quantité en stock: <?php echo $stock; ?></p>
                        </div>
                    </form>
                </div>
                <?php }}?>
        <p>
            Sous-total : <?php echo $totalPrice ?> $
        </p>
        <form action="cart.php" method="post">
            <button type="submit" class="btn btn-outline-primary">Passer la commande</button>
        </form>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>

</html>
<?php $conn = null; ?>