<?php
include "SignupFactory.php";
if(isset($_POST["email"], $_POST["password"], $_POST["auth_code"], $_POST["f_name"], $_POST["l_name"]))
{
    $signup = new SignupFactory($_POST["email"], $_POST["password"], $_POST["auth_code"], $_POST["f_name"], $_POST["l_name"]);
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