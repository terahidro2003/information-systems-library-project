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
        
            if(isset($_REQUEST['data']) && $auth->role == 1){
                $request = $_REQUEST['data'];
                switch ($request) {
                    case 'get_all_users':
                        //check id, title or author in library_books
                        if($stmt = $db->con->prepare('SELECT * FROM auth_users'))
                        {
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($row = $result->fetch_assoc())
                            {
                                $returnable[] = $row;
                            }
                        }
                        break;
                    case 'make_admin':
                        if(!isset($_REQUEST['id'])) break;

                        if($stmt = $db->con->prepare('UPDATE auth_users SET role=1 WHERE id=?'))
                        {
                            $stmt->bind_param('s', $_REQUEST['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($row = $result->fetch_assoc())
                            {
                                $returnable[] = $row;
                            }
                        }
                        break;
                    case 'delete_user':
                        if(!isset($_REQUEST['id'])) break;

                        if($stmt = $db->con->prepare('DELETE FROM auth_users WHERE id=?'))
                        {
                            $stmt->bind_param('s', $_REQUEST['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($row = $result->fetch_assoc())
                            {
                                $returnable[] = $row;
                            }
                        }
                        break;

                    default:
                        # code...
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