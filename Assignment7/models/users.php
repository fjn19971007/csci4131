<?php
class userDatabase {
    private $conn;

    public function __construct() {
        $this->conn=new mysqli('cse-curly.cse.umn.edu','F17CS4131U28','3006','F17CS4131U28','3306');
        if ( $this->conn->connect_error ) {
            echo 'Failed to connect to MySQL:' . mysqli_connect_error();
        }
    }

    public function checkLogin($login, $password) {
        global $errorMessage;
        
        $sql = "SELECT * FROM tbl_accounts WHERE acc_login='$login'";
        $result = mysqli_query($this->conn, $sql);
        
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
                header('Location: ./calendar.php');
            }
        }
    }
}


?>
