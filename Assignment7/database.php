<?php

$con= mysqli_connect('cse-curly.cse.umn.edu','F17CS4131U28','3006','F17CS4131U28','3306');
// Check connection
if (mysqli_connect_errno())
  {
  echo 'Failed to connect to MySQL:' . mysqli_connect_error();
  }

//You can replace the strings below with whatever passwords you would like
else {
  $sql = "SELECT * FROM tbl_accounts WHERE acc_login='JiananFang';";
  $result = mysqli_query($con, $sql);
  if($result->num_rows == 0) {
    $str1 = "12345";

    // You can replace the 
    //'Jim Smith', 'Smitty'   And
    //'Jane Jones', 'JJones'
    //with whatever account names and logins that you would like
    //NOTE, you can have more account names and logins than 2, but you need at least 1
    mysqli_query($con,"INSERT INTO tbl_accounts (acc_name, acc_login, acc_password) VALUES ('Jianan Fang', 'JiananFang', '". sha1($str1)."');");

    mysqli_close($con);
  }
}
?> 

