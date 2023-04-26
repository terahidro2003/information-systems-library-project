<?php
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: /auth/login.html');
	exit;
}

// Change this to your connection info.
$DATABASE_HOST = '172.19.0.2';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'librarysystemroot123';
$DATABASE_NAME = 'libraryDB';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME, 3306);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

//required tables list
$tables = ["auth.users", "auth.codes"];

//check if required tables exist
foreach($tables as $table)
{
		// if table does not exist, PHP will throw SQL Exception
		try {    
			$con->query('DESCRIBE '.$table.'');
			throw new Exception("MySQL error $con->error <br> Query:<br> $query", $msqli->errno);    
		} catch(Exception $e ) {	//table does not exist
			//echo "Error No: ".$e->getCode(). " - ". $e->getMessage() . "<br >";
			//echo nl2br($e->getTraceAsString());
			echo "Table ".$table." does not exist<br>\n"; //message 
		}
}
