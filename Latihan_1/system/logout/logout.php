<?php
session_start();

// logout
if(isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
    unset($_SESSION['LOGGED_IN']);
}

session_destroy();

header('Location: ../../views/login/login.php');
