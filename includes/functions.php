<?php declare(strict_types=1);

function redirectToIndexAndExit() {
    header('Location: index.php');
    exit();
}

function getValidatedUserId(PDO $conn) : int {
    $userDao = new UserDAO($conn);
    
    $user = $userDao->getValidatedUser($_POST['email'], $_POST['password']);
    if ($user == null) {
        $userId = -1;
    } else {
        $userId = $user->getId();
    }

    return $userId;
}
?>