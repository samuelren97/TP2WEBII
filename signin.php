<?php
session_start();
$fileName = substr(__FILE__, strrpos(__FILE__, '\\')+1);
require_once('includes/connection.php');
require_once('classes/user.class.php');
require_once('includes/functions.php');

if (isset($_SESSION['email']))
    redirectToIndexAndExit();

$hasFormErrors = false;
$hasLoginError = false;
$email = '';
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$isNewUser = isset($_GET['new_user']);

if ($isPost && isset($_POST['email'])) {
    $email = $_POST['email'];
    
    if (!isValidEmail($email) || empty($_POST['password'])) {
        $hasFormErrors = true;
    } else {
        $userDao = new UserDAO($conn);
        $user = $userDao->getValidatedUser($email, $_POST['password']);
        
        if ($user != null) {
            $_SESSION['email'] = $user->getEmail();
            header('Location: index.php?login=true');
            exit;
        } else {
            $hasLoginError = true;
        }
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
        <form class="row needs-validation m-5" action="signin.php" method="post" id='signin' novalidate>
                <h4>Se connecter</h4>
                <div class="col-lg-6 col-md-12">
                    <label for="email" class="form-label">Courriel</label>
                    <input type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="<?php echo $email; ?>"
                        required>
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
            <div class="m-5 toast show position-fixed bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger">
                    <strong class="me-auto text-white">Erreur</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Il y a une erreur avec vos informations de connexion
                </div>
            </div>
        <?php
        }
        if ($hasFormErrors) {?>
            <div class="m-5 toast show position-fixed bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger">
                    <strong class="me-auto text-white">Erreur(s)</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <ul>
                        <?php 
                        if(!isValidEmail($email)){
                            echo "<li>Le courriel n'est pas valide.</li>";
                        }
                        if(empty($_POST['password'])){
                            echo "<li>Le mot de passe est obligatoire.</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php }
        if ($isNewUser) { ?>
            <div class="m-5 toast show position-fixed bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-success">
                    <strong class="me-auto text-white">Succès</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <ul>
                        Votre compte a été crée avec succès.
                    </ul>
                </div>
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