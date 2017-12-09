<?php
session_start();

// Check if the user logged out.
if($_GET['logout'] == 'true') {
    session_unset();
    session_destroy();
    header("Location: login.php");
}
// Check the session to see whether the user logged in.
$userName = "";
if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $userName .= $_SESSION['name'];
} else {
    header("Location: login.php");
}

include_once "./models/account.php";
$database = new accountDatabase();
$accounts = $database->fetchUsers();

// ADD new user in database
if(isset($_POST['addsubmit'])) {
    $add_errorMessage = "";
    $addName = $_POST['addname'];
    $addLogin = $_POST['addlogin'];
    $addHashPassword = sha1($_POST['addpassword']);

    if(!$database->addUser($addName, $addLogin, $addHashPassword)) {
        $add_errorMessage .= "The login you entered has already been 
            taken by another user. Please enter a new login.";
    } else {
        $add_errorMessage .= "Account added successfully.";
    }
}



// UPDATE and DELETE users' information
// Check if the Update action is valid
$edit_errorMessage = "";
foreach($accounts as $acc) {
    if(isset($_POST['update' . $acc['acc_id']])) {
        if($_POST['name' . $acc['acc_id']] == "") {
            $newName = $acc['acc_name'];
        } else {
            $newName = $_POST['name' . $acc['acc_id']];
        }
        if($_POST['login' . $acc['acc_id']] == "" || $_POST['login' . $acc['acc_id']] == $acc['acc_login']) {
            $newLogin = $acc['acc_login'];
        } else {
            if(!$database->checkRepeatLogin($_POST['login' . $acc['acc_id']])) {
                $edit_errorMessage .= "The login you entered has already been taken by another user. Please enter a new login.";
            } else {
                $newLogin = $_POST['login' . $acc['acc_id']];
            }
        }
        if($_POST['password' . $acc['acc_id']] == "") {
            $newHashPassword = $acc['acc_password'];
        } else {
            $newHashPassword = sha1($_POST['password' . $acc['acc_id']]);
        }

        if(empty($edit_errorMessage)) {
            $database->updateUser($acc['acc_id'], $newName, $newLogin, $newHashPassword);
            $edit_errorMessage .= "Account updated successfully.";
        }        
    }
    
    // DELETE action
    if(isset($_POST['delete' . $acc['acc_id']])) {
        $database->deleteUser($acc['acc_id']);
    }
}




// Build up table with normal <td> and Edit <td><input>
$accounts = $database->fetchUsers();
$user_table = "";
foreach($accounts as $acc) {
    if(isset($_POST['edit' . $acc['acc_id']])) {
        $user_table .= "<tr> 
                            <td>" . $acc['acc_id'] . "</td>
                            <td><input type='text' name='name" . $acc['acc_id'] . "'></td>
                            <td><input type='text' name='login" . $acc['acc_id'] . "'></td>
                            <td><input type='text' name='password" . $acc['acc_id'] . "'></td>
                            <td>
                                <input type='submit' name='update" . $acc['acc_id'] . "' value='Update'>
                                <input type='submit' name='cancel" . $acc['acc_id'] . "' value='Cancel'>
                            </td>
                        </tr>";
    } else {
        $user_table .= "<tr> 
                            <td>" . $acc['acc_id'] . "</td>
                            <td>" . $acc['acc_name'] . "</td>
                            <td>" . $acc['acc_login'] . "</td>
                            <td> </td>
                            <td>
                                <input type='submit' name='edit" . $acc['acc_id'] . "' value='Edit'>
                                <input type='submit' name='delete" . $acc['acc_id'] . "' value='Delete'>
                            </td>
                        </tr>";
    }
}
                        

include_once "./views/users_view.php";
?>
