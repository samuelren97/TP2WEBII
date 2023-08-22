<?php
session_start();
$fileName = substr(__FILE__, strrpos(__FILE__, '\\')+1);
require_once('includes/connection.php');
require_once('classes/user.class.php');
require_once('includes/functions.php');

$hasLoginError = false;

if (isset($_POST['email'])) {
    $userId = getValidatedUserId($conn);
    
    if ($userId != -1) {
        $_SESSION['userId'] = $userId;
        redirectToIndexAndExit();
    } else {
        $hasLoginError = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src='js/validationSignin.js'></script>

    <title>Se Connecter | Maverick Custom Shop</title>
    <?php require_once('includes/head.php'); ?>
</head>
<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>

    <main class="container-fluid">
        <form class="row needs-validation" action="signin.php" method="post" id='signin' novalidate>
                <h4>Se connecter</h4>
                <div class="col-lg-6 col-md-12">
                    <label for="email" class="form-label">Courriel</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">
                        Votre courriel est obligatoire
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">
                        Le mot de passe est obligatoire
                    </div>
                </div>
            <div class="col-12 mt-3">
                <button class="btn btn-primary" type="submit">Se connecter</button>
            </div>
        </form>

        <?php
        if ($hasLoginError) {
        ?>
            <div class="alert alert-danger" role="alert">
                <p>Il y a un erreur avec vos informations de connexion</p>
            </div>
        <?php
        }
        $conn = null;
        ?>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>
</html>