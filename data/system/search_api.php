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
        
            if(isset($_REQUEST['data'], $_REQUEST['query'])){
                $request = $_REQUEST['data'];
                $like =  "%".$_REQUEST['query']."%";
        
                //check id, title or author in library_books
                if($stmt = $db->con->prepare('SELECT * FROM view_books_with_covers WHERE title LIKE ? OR description LIKE ? OR author LIKE ?'))
                {
                    $stmt->bind_param('sss',$like, $like, $like);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc())
                    {
                        $returnable[] = $row;
                    }
                }
                
                // if($auth->role == 1)
                // {
                //     //check for emails in auth_users (if admin)
                //     if($stmt = $db->con->prepare('SELECT * FROM auth_users WHERE email LIKE ?'))
                //     {
                //         $stmt->bind_param('s', $like);
                //         $stmt->execute();
                //         $result = $stmt->get_result();
                //         while($row = $result->fetch_assoc())
                //         {
                //             $returnable[] = $row;
                //         }
                //     }
                // }
                
                print json_encode($returnable);
            }
        }
    }else{
        echo "403 - UNAUTHORIZED";
        echo $_REQUEST['token'];
    }

?>