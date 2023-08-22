<?php
$fileName = substr(__FILE__, strrpos(__FILE__, '\\')+1);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src='js/validationSignup.js'></script>

    <title>Créer un compte | Maverick Custom Shop</title>
    <?php require_once('includes/head.php'); ?>
</head>
<body>
    <header>
        <?php include('includes/navbar.php'); ?>
    </header>

    <main class="container-fluid">
        <form class="needs-validation" action="newUser.php" method="post" id='signup' novalidate>
            <fieldset class="row mt-3">
                <h4>Informations sur le compte</h4>
                <div class="col-md-12">
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
                <div class="col-lg-6 col-md-12">
                    <label for="passwordConf" class="form-label">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" id="passwordConf" name="passwordConf" required>
                    <div class="invalid-feedback">
                        Entrez de nouveau votre mot de passe
                    </div>
                </div>
            </fieldset>
            <fieldset class="row mt-3">
                <h4>Informations sur la livraison</h4>
                <div class="col-lg-6 col-md-12">
                    <label for="firstName" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                    <div class="invalid-feedback">
                        Votre nom est obligatoire
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <label for="lastName" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                    <div class="invalid-feedback">
                        Votre prénom est obligatoire
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="shippingAddress" class="form-label">Adresse de livraison</label>
                    <input type="text" class="form-control" id="shippingAddress" name="shippingAddress" required>
                    <div class="invalid-feedback">
                        Votre adresse est obligatoire
                    </div>
                </div>
            </fieldset>
            <div class="col-12 mt-3">
                <button class="btn btn-primary" type="submit">S'inscrire</button>
            </div>
        </form>
    </main>
    <footer>
        <?php include('includes/footer.php'); ?>
    </footer>
</body>
</html>