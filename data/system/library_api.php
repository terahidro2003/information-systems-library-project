<?php
 error_reporting(1);
    if(isset($_REQUEST['token']))
    {
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
                        if($stmt = $db->con->prepare('SELECT * FROM library_books'))
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
                        if($stmt = $db->con->prepare('SELECT * FROM library_books WHERE id=?'))
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
                        $fields = array(
                            'id' => isset($_REQUEST['id']) ? $_REQUEST['id'] : "null",
                            'title' => isset($_REQUEST['title']) ? $_REQUEST['title'] : "null",
                            'description' => isset($_REQUEST['description']) ? $_REQUEST['description'] : "null",
                            'quantity' => isset($_REQUEST['quantity']) ? $_REQUEST['quantity'] : "null",
                            'year_published' => isset($_REQUEST['year_published']) ? $_REQUEST['year_published'] : "null",
                            'author_group_id' => isset($_REQUEST['author_group_id']) ? $_REQUEST['author_group_id'] : "null",
                            'publisher_id' => isset($_REQUEST['publisher_id']) ? $_REQUEST['publisher_id'] : "null",
                            'added_by_user' => isset($_REQUEST['added_by_user']) ? $_REQUEST['added_by_user'] : "null",
                            'ISBN_type' => isset($_REQUEST['ISBN_type']) ? $_REQUEST['ISBN_type'] : "null",
                            'ISBN_identifier' => isset($_REQUEST['ISBN_identifier']) ? $_REQUEST['ISBN_identifier'] : "null",
                            'page_count' => isset($_REQUEST['page_count']) ? $_REQUEST['page_count'] : "null",
                            'cover_image_id' => isset($_REQUEST['cover_image_id']) ? $_REQUEST['cover_image_id'] : "null",
                            'language' => isset($_REQUEST['language']) ? $_REQUEST['language'] : "null",
                            'type' => isset($_REQUEST['type']) ? $_REQUEST['type'] : "null",
                            'created_at' => date("Y-m-d H:i:s", time()),
                            'updated_at' => date("Y-m-d H:i:s", time()),
                            'deleted_at' => date("Y-m-d H:i:s", time())
                        );
                        if($stmt = $db->con->prepare("INSERT INTO library_books (id, title, description, quantity, year_published, author_group_id, publisher_id, added_by_user, ISBN_type, ISBN_identifier, page_count, cover_image_id, language, type, created_at, updated_at, deleted_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"))
                        {
                            
                            $stmt->bind_param('sssssssssssssssss', 
                                $fields['id'], 
                                $fields['title'],
                                $fields['description'],
                                $fields['quantity'],
                                $fields['year_published'],
                                $fields['author_group_id'],
                                $fields['publisher_id'],
                                $fields['added_by_user'],
                                $fields["ISBN_type"],
                                $fields["ISBN_identifier"],
                                $fields["page_count"],
                                $fields["cover_image_id"],
                                $fields["language"],
                                $fields["type"],
                                $fields["created_at"],
                                $fields["updated_at"],
                                $fields["deleted_at"]
                            );
                            
                            if($stmt->execute()) echo "SUCCESS";
                            else echo "FAILED";
                        }
                        else{
                            echo "FAILED";
                        }
                        break;
                    case 'delete_books':
                        if(!isset($_REQUEST['id'])) break;
                        if($stmt = $db->con->prepare('DELETE FROM library_books WHERE id=?'))
                        {
                            $stmt->bind_param('i', $_REQUEST['id']);
                            if($stmt->execute())
                            {
                                echo "SUCCESS";
                            }else{
                                echo "FAILED";
                            }
                        }else{
                            echo "FAILED";
                        }
                        break;
                    case 'edit_books':
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
    }

?>