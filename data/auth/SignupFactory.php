<?php
require "../helpers/validator.php";
require "../database/DatabaseConnection.php";
// require "authenticate.php";
// include "../database/connection.php";

class SignupFactory {
    //data variables:
    private $email;
    private $password;
    private $authCode;
    private $firstName;
    private $lastName;

    public $status = "ONGOING";

    public $valid;
    public $emailErr;
    public $passwordErr;
    public $authCodeErr;
    public $nameErr;

    private $databaseConnection;

    function __construct($email, $password, $auth, $fname, $lname)
    {
        $this->email = $email;
        $this->password = $password;
        $this->authCode = $auth;
        $this->firstName = $fname;
        $this->lastName = $lname;
        $this->databaseConnection = new DatabaseConnection("auth");
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
            $this->status = "VALID";
            $signup_message =  "<div class='alert alert-success'>Validation passed</div>";
            return;
        }
        // else if($this->emailErr) {$signup_message =  "<div class='alert alert-warning'>Invalid email</div>";}
        // else if($this->passwordErr) {$signup_message =  "<div class='alert alert-warning'>Invalid password</div>";}
        // else if($this->authCodeErr) {$signup_message =  "<div class='alert alert-warning'>Invalid authentication code</div>\n";}
        // else if($this->nameErr) {$signup_message =  "<div class='alert alert-warning'>Invalid name or lastname</div>";}
        $this->status = "NON-VALID";
    }

    public function save()
    {
        if($this->valid)
        {
            if($stmt = $this->databaseConnection->con->prepare('INSERT INTO auth_users (email, password, created_at, updated_at) VALUES (?,?,?,?)'))
            {
                $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bind_param('ssss', $this->email, $hashed_password, date('Y-m-d H:i:s',time()), date('Y-m-d H:i:s',time()));
                if($stmt->execute())
                {
                    $this->status = "SUCCESS";
                    echo "Signup successfull\n";
                }
                else{
                    $this->status = "FAILED";
                    echo "FAILED\n";
                }
            }else{
                echo "ERROR\n";
            }
        }
    }
}