<?php
require "../helpers/validator.php";
// require "authenticate.php";
require "../database/connection.php";

class SignupFactory {
    //data variables:
    private $email;
    private $password;
    private $authCode;
    private $firstName;
    private $lastName;

    public $valid;
    private $emailErr;
    private $passwordErr;
    private $authCodeErr;
    private $nameErr;

    function __construct($email, $password, $auth, $fname, $lname)
    {
        $this->email = $email;
        $this->password = $password;
        $this->authCode = $auth;
        $this->firstName = $fname;
        $this->lastName = $lname;
    }

    public function validate()
    {
        if(!validator::email($this->email)) $this->emailErr = true;
        if(!validator::password($this->password)) $this->passwordErr = true;
        if(!validator::authCode($this->authCode)) $this->authCodeErr = true;
        if(!validator::textNotEmpty($this->firstName) || !validator::textNotEmpty($this->lastName)) $this->nameErr = true;
        $this->valid = true;
        if($this->emailErr || $this->passwordErr || $this->authCodeErr || $this->nameErr) {
            $this->valid = false;
        }
        if($this->valid)
        {
            echo "<div class='alert alert-success'>Validation passed</div>";
        }
        else if($this->emailErr) {echo "<div class='alert alert-warning'>Invalid email</div>";}
        else if($this->passwordErr) {echo "<div class='alert alert-warning'>Invalid password</div>";}
        else if($this->authCodeErr) {echo "<div class='alert alert-warning'>Invalid authentication code</div>\n";}
        else if($this->nameErr) {echo "<div class='alert alert-warning'>Invalid name or lastname</div>";}
    }

    public function save()
    {
        if($this->valid)
        {
            if($stmt = $con->prepare('INSERT INTO auth_users (email, password) VALUES ?,?'))
            {
                $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bind_param('ss', $this->email, $this->password);
                $stmt->execute();
                echo "Signup successfull\n";
            }else{
                echo "ERROR\n";
            }
        }
    }
}