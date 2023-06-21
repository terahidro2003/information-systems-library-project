<?php

class DatabaseConnection{
    private $db_host = '172.19.0.1';
    private $db_user = 'root';
    private $db_pwd = 'librarysystemroot123';
    private $db_name = 'final';

    private $type;
    public $con;

    function __construct($type)
    {
        $this->type = $type;
        $this->connect();
        $this->check_if_tables_exist();
    }

    public function connect()
    {
        $this->con = mysqli_connect($this->db_host, $this->db_user, $this->db_pwd, $this->db_name, 3306);
        if ( mysqli_connect_errno() ) {
            // If there is an error with the connection, stop the script and display the error.
            exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
    }

    private function check_if_tables_exist()
    {
        //required tables list
        $tables = [
            "auth_users", 
            "auth_login_history", 
            "library_books", 
            "library_leases", 
            "files",
            "view_leased_books",
            "view_leases",
            "view_books_with_covers",
            "stats_leases_status",
            "leases_stats"
        ];

        //check if required tables exist
        foreach($tables as $table)
        {
                // if table does not exist, PHP will throw SQL Exception
                try {    
                    $rez = $this->con->query('DESCRIBE '.$table.'');
                    if($rez->num_rows == 0)
                    {
                        throw new Exception("MySQL error: $con->error, $con->errno");    
                    }
                } catch(Exception $e ) {	//table does not exist
                    $this->con->query(file_get_contents("../_config/tables/$table.sql"));
                }
        }
    }
}

?>