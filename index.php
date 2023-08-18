<?php declare(strict_types=1);
session_start();
$fileName = substr(__FILE__, strrpos(__FILE__, '\\')+1);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maverick Custom Shop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>
    <main>
        <div class="row">
            <!-- FIXME: Debugging matter -->
            <div class="col-lg-6 col-md-12">
                <img src="images/bcrich_large.jpg">
            </div>
            <div class="col-lg-6 col-md-12">
                <img src="images/bcrich_large.jpg">
            </div>
            <div class="col-lg-6 col-md-12">
                <img src="images/bcrich_large.jpg">
            </div>
            <div class="col-lg-6 col-md-12">
                <img src="images/bcrich_large.jpg">
            </div>
        </div>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>

</html>