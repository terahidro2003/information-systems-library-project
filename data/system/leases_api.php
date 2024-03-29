<?php
    if(isset($_REQUEST['token']))
    {
        $fields = array(
            'id' => isset($_REQUEST['id']) ? $_REQUEST['id'] : "null",
            'book_id' => isset($_REQUEST['book_id']) ? $_REQUEST['book_id'] : "null",
            'user_id' => isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "null",
            'status' => isset($_REQUEST['status']) ? $_REQUEST['status'] : null,
            'deadline' => isset($_REQUEST['deadline']) ? $_REQUEST['deadline'] : null,
            'created_at' => date("Y-m-d H:i:s", time()),
            'updated_at' => date("Y-m-d H:i:s", time())
        );
        
         //authentication
        require "../auth/authenticate.php";
        $auth = new Authentication();
        if($auth->api_authenticate($_REQUEST['token']))
        {
            $db = new DatabaseConnection("auth");

            $returnable = array();
        
            if(isset($_REQUEST['data'])){
                $request = $_REQUEST['data'];
        
                switch ($request) {
                    case 'get_all_leases':
                        if($stmt = $db->con->prepare('SELECT * FROM view_leases'))
                        {
                            $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc())
                                {
                                    $returnable[] = $row;
                                }
                        }
                        break;
                    case 'get_lease_by_user':

                        //validation
                        if(!isset($_REQUEST['id'])) break;

                        if($stmt = $db->con->prepare('SELECT * FROM view_leases WHERE id=?'))
                        {
                            $stmt->bind_param('i', $_REQUEST['id']);
                            $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc())
                                {
                                    $returnable[] = $row;
                                }
                        }
                        break;
                    case 'get_current_leases':
                        if($stmt = $db->con->prepare('SELECT * FROM view_leases WHERE email=?'))
                        {
                            $stmt->bind_param('s', $auth->email);
                            $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc())
                                {
                                    $returnable[] = $row;
                                }
                        }
                        break;
                    case 'insert_lease':
                        
                        
                        if($stmt = $db->con->prepare("INSERT INTO library_leases (book_id, user_id, status, deadline, created_at, updated_at) VALUES (?,?,?,?,?,?)"))
                        {
                            
                            $current_timestamp = date("Y-m-d H:i:s", time());
                            $default_deadline =  date('Y-m-d H:i:s', strtotime($current_timestamp. ' + 30 days'));
                            $status = "PENDING APPROVAL";

                            $stmt->bind_param('iissss', 
                                $fields['id'],
                                $auth->user_id,
                                $status,   //inserts are done
                                $default_deadline,
                                $current_timestamp,
                                $current_timestamp
                            );
                            
                            

                            if($stmt->execute()){
                                $returnable["status"] =  "SUCCESS";
                                $returnable["id"] = mysqli_stmt_insert_id($stmt);
                            }
                            else $returnable = "FAILED";
                        }
                        else{
                            echo "FAILED";
                        }
                        break;
                    case 'delete_lease':
                        //validation
                        if(!isset($_REQUEST['id'])) break;
                        if($auth->role != 1) break; //regular user is not authorized to change status

                        if($stmt = $db->con->prepare('DELETE FROM library_leases WHERE id=?'))
                        {
                            $stmt->bind_param('i', $_REQUEST['id']);
                            if($stmt->execute())
                            {
                                $returnable = "SUCCESS";
                            }else{
                                echo "FAILED";
                            }
                        }else{
                            echo "FAILED";
                        }
                        break;
                    case 'edit_lease':
                        //validation
                        if(!isset($_REQUEST['id'])) break;
                        if($auth->role != 1) break; //regular user is not authorized to change status
                        
                        if($stmt = $db->con->prepare("UPDATE library_books SET book_id=?, user_id=?, status=?, deadline=?, updated_at=? WHERE id=?"))
                        {
                            $stmt->bind_param('ssssss', 
                                $fields['book_id'],
                                $fields['user_id'],
                                $fields['status'],
                                $fields['deadline'],
                                $current_timestamp,
                                $_REQUEST["id"]
                            );
                            
                            if($stmt->execute()) $returnable = "SUCCESS";
                            else echo "FAILED";
                        }
                        else{
                            echo "FAILED";
                        }
                        break;
                        case 'change_status':
                            //validation
                            
                            if(!isset($_REQUEST['id'])) break;
                            if(!isset($_REQUEST['status'])) break;
                            
                            if($stmt = $db->con->prepare("UPDATE library_leases SET status=?, updated_at=? WHERE id=?"))
                            {
                                $current_timestamp = date("Y-m-d H:i:s", time());
                                $stmt->bind_param('ssi', 
                                    $fields['status'],
                                    $current_timestamp,
                                    $_REQUEST["id"]
                                );
                                
                                if($stmt->execute()) $returnable["status"] = "SUCCESS";
                                else $returnable["status"] = "FAILED";
                            }
                            else{
                                echo "FAILED";
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