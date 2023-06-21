<?php
    if(isset($_REQUEST['token']))
    {
        $fields = array(
            'id' => isset($_REQUEST['id']) ? $_REQUEST['id'] : "null",
            'title' => isset($_REQUEST['title']) ? $_REQUEST['title'] : "null",
            'description' => isset($_REQUEST['description']) ? $_REQUEST['description'] : "null",
            'quantity' => isset($_REQUEST['quantity']) ? $_REQUEST['quantity'] : null,
            'year_published' => isset($_REQUEST['year_published']) ? $_REQUEST['year_published'] : null,
            'author' => isset($_REQUEST['author']) ? $_REQUEST['author'] : null,
            'added_by_user' => isset($_REQUEST['added_by_user']) ? $_REQUEST['added_by_user'] : null,
            'ISBN_identifier' => isset($_REQUEST['ISBN_identifier']) ? $_REQUEST['ISBN_identifier'] : "null",
            'page_count' => isset($_REQUEST['page_count']) ? $_REQUEST['page_count'] : null,
            'cover_image_id' => isset($_REQUEST['cover_image_id']) ? $_REQUEST['cover_image_id'] : null,
            'language' => isset($_REQUEST['language']) ? $_REQUEST['language'] : "null",
            'type' => isset($_REQUEST['type']) ? $_REQUEST['type'] : "null",
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
                    case 'get_all_books':
                        if($stmt = $db->con->prepare('SELECT * FROM view_books_with_covers'))
                        {
                            $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc())
                                {
                                    
                                    $returnable[] = $row;
                                }
                        }
                        break;
                    case 'get_book_by_id':
                        if(!isset($_REQUEST['id'])) break;
                        if($stmt = $db->con->prepare('SELECT * FROM view_books_with_covers WHERE id=?'))
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
                    case 'insert_books':
                        if($auth->role != 1) break; //regular user is not authorized to change status
                        if($stmt = $db->con->prepare("INSERT INTO library_books (title, description, quantity, year_published, author, added_by_user, ISBN_identifier, page_count, language, type, created_at, updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)"))
                        {
                            $current_timestamp = date("Y-m-d H:i:s", time());
                            $user_id = $auth->user_id;
                            
                            $stmt->bind_param('ssssssssssss', 
                                $fields['title'],
                                $fields['description'],
                                $fields['quantity'],
                                $fields['year_published'],
                                $fields['author'],
                                $user_id,
                                $fields["ISBN_identifier"],
                                $fields["page_count"],
                                $fields["language"],
                                $fields["type"],
                                $current_timestamp,
                                $current_timestamp
                            );

                            echo "";
                            
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
                    case 'delete_books':
                        if($auth->role != 1) break; //regular user is not authorized to change status
                        if(!isset($_REQUEST['id'])) break;
                        if($stmt = $db->con->prepare('DELETE FROM library_books WHERE id=?'))
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
                    case 'edit_books':
                        if($auth->role != 1) break; //regular user is not authorized to change status
                        if(!isset($_REQUEST['id'])) break;
                        echo "S";
                        if($stmt = $db->con->prepare("UPDATE library_books SET title=?, description=?, quantity=?, year_published=?, author=?, added_by_user=?, ISBN_identifier=?, page_count=?, language=?, type=?, updated_at=? WHERE id=?"))
                        {
                            
                            $stmt->bind_param('ssssssssssss', 
                                $fields['title'],
                                $fields['description'],
                                $fields['quantity'],
                                $fields['year_published'],
                                $fields['author'],
                                $fields['added_by_user'],
                                $fields["ISBN_identifier"],
                                $fields["page_count"],
                                $fields["language"],
                                $fields["type"],
                                $fields["updated_at"],
                                $_REQUEST["id"]
                            );
                            
                            if($stmt->execute()) $returnable = "SUCCESS";
                            else echo "FAILED";
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