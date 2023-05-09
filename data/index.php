<?php
// ob_start();
// session_start();
require "auth/authenticate.php";

if(!isset($_COOKIE['LIMS.auth']))
{
	header("Location: /auth/login.php");
    exit();
}else
{
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT session_token FROM auth_login_history WHERE ')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
       // $stmt->bind_param('s', $_COOKIE['LIMS.auth']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($token);
            $stmt->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            if (password_verify($_COOKIE['LIMS.auth'], $token)) {
                // Verification success! User has logged-in!
                // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['token'] = $token;
                
                header("Location: /system/index.php");
                exit();
            } else {
                // Incorrect password
                //echo 'Incorrect username and/or password!';
            }
        }
        $stmt->close();
    }
    }
