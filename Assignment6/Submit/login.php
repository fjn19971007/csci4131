<?php
session_start();
include_once "database_HW6F17.php";
// Create connection
$conn=new mysqli($db_servername,$db_username,$db_password,$db_name,$db_port);
if ( $conn->connect_error ) {
    echo 'Failed to connect to MySQL:' . mysqli_connect_error();
} 

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
        $sql = "SELECT * FROM tbl_accounts WHERE acc_login='$login'";
        $result = mysqli_query($conn, $sql);

        if($result->num_rows == 0) {
            $errorMessage .= "User does not exist. Please check the login details and try again.<br>";
        } else {
            $account = mysqli_fetch_assoc($result);
            $dbPassword = $account['acc_password'];
            if($dbPassword != sha1($password)) {
                $errorMessage .= "Please check the password and try again.<br>";
            } else {
                $_SESSION['name'] = $account['acc_name'];
                $_SESSION['username'] = $login;
                $_SESSION['password'] = $password;
                header('Location: calendar.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="login.css">
        <title>Login Page</title>
    </head>
    <body>
        <div class="loginDiv">
        <h1>Login Page</h1>
        <form class="loginTable" action="login.php" method="POST">
            <div class="errorMessage">
                <?php
                    if(!empty($errorMessage)) {
                        echo '<p>' . $errorMessage . '</p>' ;
                    }
                ?>
            </div>
            <p>Please enter your user's login name and password. Both values are case sensitive</p><br>
            <p>
                <label>Login: </label>
                <input id="login" type="text" name="login"><br>
            </p>
            <p>
                <label>Password: </label>
                <input id="password" type="text" name="password"><br>
            </p>
            <p>
                <input class="submit" type="submit" name="submit">
            </p>
        </div>
    </body>
