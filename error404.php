<?php 
$fileName = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404 | Maverick Custom Shop</title>
    <?php include_once('includes/head.html'); ?>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <?php include_once('includes/navbar.php'); ?>
    </header>
    <main>
        <div class="banner-container mb-3">
            <div class="banner">
                <div class="title">
                    <h1 class="text-white">
                        Erreur 404
                    </h1>
                </div>
                <p class="mb-5 sub-title text-white text-center">
                    La page recherchée n'existe pas (ou plus)
                </p>
            </div>
        </div>

    </main> 
    <?php include_once('includes/footer.html'); ?>
</body>
</html>