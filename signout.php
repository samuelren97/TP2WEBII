<?php
session_start();
require_once('includes/functions.php');

if (isset($_SESSION['userId'])) {
    unset($_SESSION['userId']);
    header('Location: index.php?signout=true');
    exit;
}
redirectToIndexAndExit();
?>