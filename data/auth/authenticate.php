<?php
require "../sessions/SessionManager.php";
require "../database/DatabaseConnection.php";

class Authentication
{
	public $authenticated = false;
	public $email;
	public $role;
	protected $session;
	public $databaseConnection;

	public function __construct()
	{
		error_reporting(0);
		$this->databaseConnection = new DatabaseConnection("auth");
		$this->session = new SessionManager();
	}

	public static function check_authentication($auth)
	{
		if(!$auth->auth())
		{
			header('Location: /auth/login.php');
			exit();
		}
	}

	public function auth()
	{	
		if($this->session->has('LIMS.auth'))
		{
			// $connection = new DatabaseConnection("auth");
			if($stmt = $this->databaseConnection->con->prepare('SELECT user_id FROM auth_login_history WHERE session_token = ?'))
			{
				$stmt->bind_param('s', $this->session->get('LIMS.auth'));
				$stmt->execute();
				$stmt->store_result();
				
				if($stmt->num_rows > 0)
				{
					$stmt->bind_result($user_id);
					$stmt->fetch();
					
					if($stmt = $this->databaseConnection->con->prepare('SELECT email, role FROM auth_users WHERE id = ?'))
					{
						$stmt->bind_param('s', $user_id);
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