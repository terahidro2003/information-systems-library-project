<?php
require "../helpers/validator.php";
// require "../database/DatabaseConnection.php";
require "authenticate.php";
// include "../database/connection.php";

class SignupFactory extends Authentication{
    //data variables:
    public $email;
    public $password;
    private $authCode;
    public $firstName;
    public $lastName;

    public $status = "ONGOING";

    public $valid;
    public $emailErr;
    public $passwordErr;
    public $authCodeErr;
    public $nameErr;

    public $session;

    public $databaseConnection;

    function __construct()
    {
        $this->session = new SessionManager();
        $this->databaseConnection = new DatabaseConnection("auth");
    }

    public function signup($email, $password, $auth, $fname, $lname)
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

        //check if user with the same email address exists in DB
        if($stmt = $this->databaseConnection->con->prepare('SELECT * FROM auth_users WHERE email=?'))
        {
            $stmt->bind_param('s', $this->email);
            if($stmt->execute())
            {
                $stmt->execute();
                // Store the result so we can check if the account exists in the database.
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $this->valid = false;
                }
            }
        }


        if($this->valid)
        {
            $this->status = "VALID";
            $signup_message =  "<div class='alert alert-success'>Validation passed</div>";
            return;
        }

        
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
                    // echo "Signup successfull\n";
                }
                else{
                    $this->status = "FAILED";
                    // echo "FAILED\n";
                }
            }else{
                // echo "ERROR\n";
            }
        }
    }
}