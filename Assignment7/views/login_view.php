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
        <form class="loginTable" action="./login.php" method="POST">
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
</html>
