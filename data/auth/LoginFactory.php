<?php

require "../helpers/validator.php";
require "authenticate.php";
// require "../sessions/SessionManager.php";
// require "../database/DatabaseConnection.php";

class LoginFactory extends Authentication
{
    public $email;
    public $password;

    public $err = false;
    public $status = false;
    public $msg;
    public $valid = true;
    public $emailErr;
    public $passwordErr;
    private $auth;

    // public function __construct($e, $p)
    // {
    //     $this->email = $e;
    //     $this->password = $p;
    //     $this->databaseConnection = new DatabaseConnection("auth");
    //     $this->session = new SessionManager();
    // }

    public function __construct()
    {
        $this->databaseConnection = new DatabaseConnection("auth");
        $this->session = new SessionManager();
    }

    public function login($e, $p)
    {
        $this->email = $e;
        $this->password = $p;
    }

    public function validate()
    {
        if(!Validator::email($this->email)) $this->emailErr = true;
        if(!validator::password($this->password)) $this->passwordErr = true;
        if($this->emailErr || $this->passwordErr) $this->valid = false;
    }

    public function authenticate()
    {
        if($this->valid && !$this->authenticated)
        {
            // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
            if ($stmt = $this->databaseConnection->con->prepare('SELECT id, password FROM auth_users WHERE email = ?')) {
                // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
                $stmt->bind_param('s', $this->email);
                $stmt->execute();
                // Store the result so we can check if the account exists in the database.
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $password = "";
                    $id = "";
                    $stmt->bind_result($id, $password);
                    $this->msg = $this->email;
                    $stmt->fetch();
                    // Account exists, now we verify the password.
                    // Note: remember to use password_hash in your registration file to store the hashed passwords.
                    if (password_verify($this->password, $password)) {
                        // Verification success! User has logged-in!
                        if($stmt = $this->databaseConnection->con->prepare('INSERT INTO auth_login_history (user_id, ip_address, device_info, session_token, session_active, created_at, updated_at, deleted_at) VALUES (?,?,?,?,?,?,?,?)'))
                        {
                            $current_timestamp = date('Y-m-d H:i:s',time());
                            $old_timestamp = null;
                            $session_active = 1;
                            $session_token = uniqid();
                            //$hashed_session_token = password_hash($session_token, PASSWORD_DEFAULT);
                            $stmt->bind_param('ssssssss', 
                                $id,
                                $_SERVER['REMOTE_ADDR'],
                                $_SERVER['HTTP_USER_AGENT'],
                                $session_token,
                                $session_active,
                                $current_timestamp,
                                $current_timestamp,
                                $old_timestamp
                            );
                            if($stmt->execute())
                            {
                                $this->status = true;                                
                                $this->session->set('LIMS.auth', $session_token);

                                header("Location: /system/index.php");
                                exit();
                            }
                        }
                        
                    } else {
                        // Incorrect password
                        echo 'Incorrect username and/or password! 1';
                        $this->err = true;
                    }
                } else {
                    // Incorrect username
                    echo 'Incorrect username and/or password! 2';
                }
                $stmt->close();
            }
        }
    }
}