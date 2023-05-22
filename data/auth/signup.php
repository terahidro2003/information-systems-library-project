<?php
include "SignupFactory.php";
ob_start();
$signup = new SignupFactory();
if($signup->auth(false, null))
{
   exit(header('Location: /system/index.php'));
}

if(isset($_POST["email"], $_POST["password"], $_POST["auth_code"], $_POST["f_name"], $_POST["l_name"]))
{
    $signup->signup($_POST["email"], $_POST["password"], $_POST["auth_code"], $_POST["f_name"], $_POST["l_name"]);
    $signup->validate();
    if($signup->valid) $signup->save();
}else{
    // echo "provide all details required \n";
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
    <title>Signup | Library Managament System</title>
</head>
<body>
    <div class="auth-wrapper">
    <div class="auth-form d-flex d-flex-columns">
        <?php
            if($signup->status == "NON-VALID"){
                echo 
                    '<div class="alert alert-warning"><span class="alert-header">Invalid inputs provided</span><br/>Please correct following fields:';
                echo '<ul style="padding-left: 1em;">';
                if($signup->emailErr) echo '<li>Make sure you typed your email correctly</li>';
                if($signup->passwordErr) echo '<li>Make sure you typed a password with at least 8 symbols, 1 special character, and at least 1 number</li>';
                if($signup->authCodeErr) echo '<li>Make sure you typed signup authentication code correctly. This code can be received from your librarian</li>';
                if($signup->nameErr) echo '<li>Make sure you typed your full name correctly</li>';
                echo '</ul></div>';
            } 
        ?>
    <form action="signup.php" method="POST">
        <div>
            <label class="d-block" for="">Email:</label>
            <input class="d-block form-control" type="email" name="email" placeholder="">
        </div>
        <div class="d-flex d-flex-rows mt-8">
            <div>
                <label class="d-block" for="">First name:</label>
                <input class="d-block form-control" type="text" name="f_name" placeholder="James">
            </div>
            <div style="padding-left: 1em;">
                <label class="d-block" for="">Last Name:</label>
                <input class="d-block form-control" type="text" name="l_name" placeholder="Stovold">
            </div>
        </div>
        <div class="mt-8">
            <label class="d-block" for="">Authentication Code:</label>
            <input class="d-block form-control" type="text" name="auth_code" placeholder="Auth code">
        </div>
       <div class="mt-8">
            <label class="d-block" for="">Password:</label>
            <input class="d-block form-control" type="password" name="password" placeholder="Password">
       </div>
       <button type="submit" class="btn btn-primary mt-8 d-block">Login</button>
       <a class="link mt-6 d-block" href="#forgot-password">Already have an account? Log in here.</a>
    </div>
    <div class="auth-background"></div>
    </div>
</form>
</body>
</html>