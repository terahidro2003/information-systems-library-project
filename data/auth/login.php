<?php
ob_start();
session_start();
require "LoginFactory.php";

//check if POST request with required fields exists
if(isset($_POST['email'], $_POST['password']))
{
    $login = new LoginFactory($_POST['email'], $_POST['password']);
    $login->validate();
    $login->authenticate();
    if($login->status)
    {
        session_regenerate_id();
        $_SESSION["LIMS.auth"] = true;
        $_SESSION["email"] = $_POST['email'];
        header("Location: /system/index.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <link rel="stylesheet" href="/assets/css/ui/main.css">
    <title>Login | Library Managament System</title>
</head>
<body>
    <div class="auth-wrapper">
    <div class="auth-form d-flex d-flex-columns">
        <?php
            if(isset($login) && $login->err == false) 
            {
                echo "<div class='alert alert-danger'>";
                echo "  Incorrect login credentials";
                echo $login->msg;
                echo "</div>";
            }
        ?>
    <form action="login.php" method="POST">
        <div>
            <label class="d-block" for="">Email:</label>
            <input class="d-block form-control" type="email" name="email" placeholder="">
            <?php if(isset($login) && $login->emailErr) echo "<span style='color: red;'> Incorrectly typed email</span>"; ?>
        </div>
       <div class="mt-8">
            <label class="d-block" for="">Password:</label>
            <input class="d-block form-control" type="password" name="password" placeholder="Password">
            <?php if(isset($login) && $login->passwordErr && !$login->valid) echo "<span style='color: red;'> Incorrectly typed password</span>"; ?>
       </div>
       <button type="submit" class="btn btn-primary mt-8 d-block">Login</button>
       <a class="link mt-6 d-block" href="signup.php">Sign up here.</a>
    </div>
    <div class="auth-background"></div>
    </div>
</form>
</body>
</html>