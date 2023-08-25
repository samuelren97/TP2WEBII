<?php
session_start();
require_once('includes/connection.php');
require_once('classes/user.class.php');
require_once('includes/functions.php');

if (isset($_SESSION['email']))
    redirectToIndexAndExit();

$fileName = substr(__FILE__, strrpos(__FILE__, '\\')+1);
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$email = '';
$password = '';
$passwordConf = '';
$firstName = '';
$lastName = '';
$shippingAddress = '';

$hasFormErrors = false;
$userExists = false;

if ($isPost && isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $shippingAddress = $_POST['shippingAddress'];
    
    $isValidForm = isValidEmail($email) && !empty(trim($password)) &&
        !empty(trim($firstName)) && !empty(trim($lastName)) && !empty(trim($shippingAddress)) && 
        $password === $passwordConf;
    
    if ($isValidForm) {
        $userDao = new UserDAO($conn);

        if (!$userDao->userExists($email)) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $user = new User($email, $password, $firstName, $lastName, $shippingAddress);
            $userDao->add($user);
            header('Location: signin.php?new_user=true');
            exit;
        } else {
            $userExists = true;
        }
    } else {
        $hasFormErrors = true;
    }
}

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
        <form class="m-5 needs-validation" action="signup.php" method="post" id='signup' novalidate>
            <fieldset class="row">
                <h4>Informations sur le compte</h4>
                <div class="col-md-12 mb-3">
                    <label for="email" class="form-label mb-3">Courriel</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email" name="email" 
                        value="<?php echo $email; ?>"
                        required>
                    <div class="invalid-feedback">
                        Votre courriel est obligatoire
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <label for="password" class="form-label mb-3">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">
                        Le mot de passe est obligatoire
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <label for="passwordConf" class="form-label mb-3">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" id="passwordConf" name="passwordConf" required>
                    <div class="invalid-feedback">
                        Entrez de nouveau votre mot de passe
                    </div>
                </div>
            </fieldset>
            <fieldset class="row mt-3">
                <h4>Informations sur la livraison</h4>
                <div class="col-lg-6 col-md-12 mb-3">
                    <label for="firstName" class="form-label mb-3">Prénom</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="firstName" 
                        name="firstName" 
                        value="<?php echo $firstName; ?>"
                        required>
                    <div class="invalid-feedback">
                        Votre nom est obligatoire
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <label for="lastName" class="form-label mb-3">Nom</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="lastName" 
                        name="lastName" 
                        value="<?php echo $lastName; ?>"
                        required>
                    <div class="invalid-feedback">
                        Votre prénom est obligatoire
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="shippingAddress" class="form-label mb-3">Adresse de livraison</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="shippingAddress" 
                        name="shippingAddress" 
                        value="<?php echo $shippingAddress; ?>"
                        required>
                    <div class="invalid-feedback">
                        Votre adresse est obligatoire
                    </div>
                </div>
            </fieldset>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">S'inscrire</button>
            </div>
        </form>

        <?php 
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
                                echo "<li>Le courriel est obligatoire.</li>";
                            }
                            if(empty(trim($password))){
                                echo "<li>Le mot de passe est obligatoire.</li>";
                            }
                            else if($password !== $passwordConf){
                                echo "<li>Les mots de passe doivent être identiques.</li>";
                            }
                            if(empty(trim($firstName))){
                                echo "<li>Le prénom est obligatoire.</li>";
                            }
                            if(empty(trim($lastName))){
                                echo "<li>Le nom est obligatoire.</li>";
                            }
                            if(empty(trim($shippingAddress))){
                                echo "<li>L'adresse de livraison est obligatoire.</li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        <?php } 
        if ($userExists) { ?>
            <div class="m-5 toast show position-fixed bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger">
                    <strong class="me-auto text-white">Erreur(s)</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <p>Le courriel est malheureusement déjà pris.</p>
                </div>
            </div>
        <?php 
        }
        ?>

</main>
<footer>
    <?php include('includes/footer.php'); ?>
</footer>
</body>
</html>
<?php $conn = null; ?>