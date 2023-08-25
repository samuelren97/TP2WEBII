<?php
session_start();
require_once('includes/functions.php');

if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
    header('Location: index.php?signout=true');
    exit;
}
redirectToIndexAndExit();
?>