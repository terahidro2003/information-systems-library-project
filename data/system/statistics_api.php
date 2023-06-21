<?php
    if(isset($_REQUEST['token']))
    {
         //authentication
        require "../auth/authenticate.php";
        $auth = new Authentication();
        if($auth->api_authenticate($_REQUEST['token']))
        {
            $db = new DatabaseConnection("auth");

            $returnable = array();
            // $returnable[0] = ["status", "amount"];
        
            if(isset($_REQUEST['data'])){
                $request = $_REQUEST['data'];
        
                switch ($request) {
                    case 'statuses':
                        if($stmt = $db->con->prepare('SELECT * FROM stats_leases_status'))
                        {
                            $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_array())
                                {
                                    $returnable[] = $row;
                                }
                        }
                        break;
                  case 'leases':
                        if($stmt = $db->con->prepare('SELECT * FROM leases_stats'))
                        {
                            $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_array())
                                {
                                    $returnable[] = $row;
                                }
                        }
                        break;   
                    default:
                        $returnable = $fields;
                        break;
                }
                print json_encode($returnable);
            }
        }
    }else{
        echo "403 - UNAUTHORIZED";
        echo $_REQUEST['token'];
    }

?>