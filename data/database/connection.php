<?php
session_start();

// Change this to your connection info.
$DATABASE_HOST = '172.19.0.3';
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
$tables = ["auth_users", "auth_codes", "auth_login_history", "library_books"];

//check if required tables exist
foreach($tables as $table)
{
		// if table does not exist, PHP will throw SQL Exception
		try {    
			$rez = $con->query('DESCRIBE '.$table.'');
			if($rez->num_rows == 0)
			{
				throw new Exception("MySQL error: $con->error, $con->errno");    
			}
			//echo "All tables exist. Check done successfully";
		} catch(Exception $e ) {	//table does not exist
			//echo nl2br($e->getTraceAsString());
			//echo "Table ".$table." does not exist<br>\n"; //message 
			//echo "Creating table $table ...";
			$con->query(file_get_contents("../_config/tables/$table.sql"));
		}
}
