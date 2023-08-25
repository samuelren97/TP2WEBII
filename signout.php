<?php
session_start();

if (isset($_SESSION['userId'])) {
    // TODO: Remove session var userId
    unset($_SESSION['userId']);
    echo "OK";
}

header('Location: index.php');
exit;
?>