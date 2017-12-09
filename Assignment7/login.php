<?php
session_start();
include_once "./database.php";

$login = $_POST['login'];
$password = $_POST['password'];
$errorMessage = '';


if(!empty($_POST['submit'])) {
    if(empty($login)) {
        $errorMessage .= 'Please enter a valid value for User Login field.<br>';
    }
    if(empty($password)) {
        $errorMessage .= 'Please enter a valid value for Password field.<br>';
    }

    if(empty($errorMessage)) {
        include_once "./models/users.php";
        $userDatabase = new UserDatabase();
        $userDatabase->checkLogin($login, $password);
    }
}

include_once "./views/login_view.php";
?>

