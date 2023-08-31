<?php
session_start();
require_once('classes/cartItem.class.php');
require_once('classes/product.class.php');
require_once('includes/connection.php');
require_once('includes/functions.php');
require_once('classes/cart.class.php');
$fileName = '';
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$quantityInCart = 0;
$cart = null;
if (isset($_GET['sku'])) {
    if (is_numeric($_GET['sku'])) {
        $sku =  $_GET['sku'];
        $productDao = new ProductDao($conn);
        
        $product = $productDao->get($sku);
        if ($product == null)
            redirectToErrorPageAndExit();
    } else {
        redirectToErrorPageAndExit();
    }
} else {
    redirectToIndexAndExit();
}

if (isset($_SESSION['cart'])) {
    $cart = unserialize($_SESSION['cart']);
    $cartItems = $cart->getCartItems();
    $indexInArray = getProductIndexInArray($sku, $cartItems);
    if ($indexInArray >=0) {
        $quantityInCart = $cartItems[$indexInArray]->getProductQuantity();
    }
}

if (isset($_POST['quantity'])) {
    if ($_POST['quantity'] == 0) {
        header('Location: product.php?sku='. $sku);
        exit();
    }
    if ($_POST['quantity'] <= $product->getStock()) {
        $cartItem = new CartItem($product, $_POST['quantity']);
        $cartItem->setProductSku($sku);
        if ($cart == null) {
            $cart = new Cart();
        }
        
        $cart->addCartItem($cartItem);
        $_SESSION['cart'] = serialize($cart);
        header('Location: cart.php');
        exit();
    }
}

$name = $product->getName();
$description = $product->getDescription();
$price = $product->getPrice();
$stock = $product->getStock();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name . " | Maverick Custom Shop" ?></title>
    <?php require_once('includes/head.php'); ?>
    <script defer src="js/validationProduct.js"></script>
</head>
<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>

    <main class="row g-5 mt-3 mb-3 container-fluid">
        <div class="col-lg-6 col-md-12 text-center">
            <img src="images/<?php echo $sku;?>.png" alt="Image d'une guitare">
        </div>
        <div class="col-lg-6 col-md-12 pt-5 pb-5 border rounded">
            <h4><?php echo $name; ?></h4>
            <p><?php echo $description; ?></p>
            <h5><?php echo $price; ?>$</h5>

            <form class="needs-validation" action="product.php?sku=<?php echo $sku; ?>" method="post" novalidate>
                <div class="row g-5">
                    <div class="col-sm-12 col-md-6">
                        <input type="number" class="form-control" id="quantity" name="quantity" min='0' value='0'
                            max="<?php echo $stock - $quantityInCart; ?>"
                            required>
                        <div class="invalid-feedback">
                            La quantité demandée n'est pas valide
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <button type="submit" class="btn btn-outline-primary">Ajouter au panier</button>
                    </div>
                    <div class="col-sm-12">
                        <p class="text-success">Quantité en stock: <?php echo $stock; ?></p>
                        <p>Quantité dans le panier: <?php echo $quantityInCart;?></p>
                        <?php if ($isPost) {?>
                            <p class="text-danger">Il y a seulement <?php echo $stock?> de ce modèle en stock.</p>
                        <?php }?>
                    </div>
                </div>
            </form>

        </div>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>
</html>
<?php $conn = null; ?>