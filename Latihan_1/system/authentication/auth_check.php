<?php

session_start();

if(!isset(($_SESSION['LOGGED_IN'])) || empty($_SESSION['LOGGED_IN']) || $_SESSION['LOGGED_IN'] !== true) {
    header('location: ../../views/login/login.php');
}