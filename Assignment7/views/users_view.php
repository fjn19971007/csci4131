


<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="./admin.css">
    </head>

    <body>
        <div class="nav">
            <nav>
            <a class="left" href="./calendar.php">My Calendar</a>
            <a class="left" href="./form.php">Form Input</a>
            <a class="active" href="./admin.php">Admin</a>
            <a class="right" href="./admin.php?logout=true">Log out</a>
            <a class="right"><?php echo "Welcome " . $userName; ?></a>
            </nav>
        </div>

        <form class="userList" action="./admin.php" method="POST">
            <h2>List of Users</h2>
            <p class="errorMessage"><?php echo $edit_errorMessage; ?></p>
            <table class="table">
                <tr class="tableAttributes">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Login</th>
                    <th>New Password</th>
                    <th>Action</th>
                </tr>
                <?php echo $user_table; ?>
            </table>
        </form>

        <div class="form">
            <h2>Add New User</h2>
            <p class="errorMessage"><?php echo $add_errorMessage; ?></p>
            <form class="addUser" action="./admin.php" method="POST">
                <p>
                    <label>Name: </label>
                    <input type="text" name="addname" ><br>
                </p>
                <p>
                    <label>Login: </label>
                    <input type="text" name="addlogin"><br>
                </p>
                <p>
                    <label>Password: </label>
                    <input type="password" name="addpassword"><br>
                </p>
                <input class='addUser' type="submit" name="addsubmit" value="Add User">
            </form>
        </div>
        <p>This page is protected from public, and you can see a list of all users defined in the database.</p>
    </body>
</html>

