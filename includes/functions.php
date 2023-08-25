<?php declare(strict_types=1);

function redirectToIndexAndExit() {
    header('Location: index.php');
    exit;
}

function isValidEmail(string $email) : bool {
    $regex = "/[a-z0-9]+@[a-z]+.[a-z]{2,3}/";
    if (preg_match($regex, $email) == 1) {
        return true;
    }
    return false;
}
?>