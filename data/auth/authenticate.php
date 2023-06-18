<?php
require "../sessions/SessionManager.php";
require "../database/DatabaseConnection.php";

class Authentication
{
	public $authenticated = false;
	public $email;
	public $role;
	public $user_id;
	public $session;
	public $databaseConnection;

	public function __construct()
	{
		error_reporting(0);
		$this->databaseConnection = new DatabaseConnection("auth");
		$this->session = new SessionManager();
	}

	public function api_authenticate($token)
	{
		if(!$this->auth(true, $token))
		{
			return false;
		}
		return true;
	}

	public static function check_authentication($auth)
	{
		if(!$auth->auth(false, null))
		{
			header('Location: /auth/login.php');
			exit();
		}
		return $auth->role;	
	}

	public function auth($api, $token)
	{	
		if($this->session->has('LIMS.auth') || $api)
		{
			// $connection = new DatabaseConnection("auth");
			if($stmt = $this->databaseConnection->con->prepare('SELECT user_id FROM auth_login_history WHERE session_token = ?'))
			{
				if(!$api)
				{
					$stmt->bind_param('s', $this->session->get('LIMS.auth'));
				}else{
					$stmt->bind_param('s', $token);
				}
				
				
				$stmt->execute();
				$stmt->store_result();
				
				if($stmt->num_rows > 0)
				{
					$stmt->bind_result($this->user_id);
					$stmt->fetch();
					
					if($stmt = $this->databaseConnection->con->prepare('SELECT email, role FROM auth_users WHERE id = ?'))
					{
						$stmt->bind_param('s', $this->user_id);
						$stmt->execute();
						$stmt->store_result();

						if($stmt->num_rows > 0)
						{
							$stmt->bind_result($this->email, $this->role);
							$stmt->fetch();
							
							$this->authenticated = true;
							return true;
						}
					}
				}
			}

		}
		return false;
	}
}
    
?>