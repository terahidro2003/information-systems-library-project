<?php
// ob_start();
// session_start();
require "sessions/SessionManager.php";
require "database/DatabaseConnection.php";

        // error_reporting(0);
		$session = new SessionManager();
		if($session->has('LIMS.auth'))
		{
			$connection = new DatabaseConnection("auth");
			if($stmt = $connection->con->prepare('SELECT user_id FROM auth_login_history WHERE session_token = ?'))
			{
				$sessionToken = $session->get('LIMS.auth');
				$stmt->bind_param('s', $sessionToken);
				$stmt->execute();
				$stmt->store_result();
				
				if($stmt->num_rows > 0)
				{
					$stmt->bind_result($user_id);
					$stmt->fetch();
					
					if($stmt = $connection->con->prepare('SELECT email, role FROM auth_users WHERE id = ?'))
					{
						$stmt->bind_param('s', $user_id);
						$stmt->execute();
						$stmt->store_result();

						if($stmt->num_rows > 0)
						{
                            header("Location: /system/index.php");
                            die();
						}else{
                            header("Location: /auth/login.php");
                            die();
                        }
					}
				}else{
                    header("Location: /auth/login.php");
                    die();
                }
			}

		}else{
			header("Location: /auth/login.php");
			die();
		}