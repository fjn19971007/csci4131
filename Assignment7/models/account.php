<?php

class accountDatabase {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('cse-curly.cse.umn.edu','F17CS4131U28','3006','F17CS4131U28','3306');
        if ( $this->conn->connect_error ) {
            echo 'Failed to connect to MySQL:' . mysqli_connect_error();
        }
    }

    public function fetchUsers() {
        $sql = "SELECT * FROM tbl_accounts;";
        $result = mysqli_query($this->conn, $sql);
        $accounts = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $accounts;
    }

    public function addUser($name, $login, $hash_password) {
        $sql1 = "SELECT * FROM tbl_accounts WHERE acc_login='$login';";
        $result = mysqli_query($this->conn, $sql1);
        if($result->num_rows != 0) {
            return false;
        } else {
            $sql2 = "INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES ('$name', '$login', '$hash_password')";
            mysqli_query($this->conn, $sql2);
            return true;
        }
    }

    public function updateUser($id, $name, $login, $hash_password) {
        $sql = "UPDATE tbl_accounts SET acc_name='$name', acc_login='$login', acc_password='$hash_password' 
        WHERE acc_id='$id';";
        mysqli_query($this->conn, $sql);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM tbl_accounts WHERE acc_id='$id';";
        mysqli_query($this->conn, $sql);
    }

    public function checkRepeatLogin($login) {
        $sql = "SELECT * FROM tbl_accounts WHERE acc_login='$login';";
        $result = mysqli_query($this->conn, $sql);
        if($result->num_rows != 0) {
            return false;
        }
        return true;
    }
}

?>
