<?php 


require '../auth/authenticate.php';

        //check authentication status
        $auth = new Authentication();
        Authentication::check_authentication($auth);

        if(isset($_FILES["file"]["name"]))
        {
            $current_timestamp = date('Y-m-d H:i:s',time());

            // File upload path
            $rootDir = "files/"; 
            $fileName = basename($_FILES["file"]["name"]);
            $targetPath = $rootDir . $fileName;
            $fileType = pathinfo($targetPath,PATHINFO_EXTENSION);

            //Check if file type is allowed
            $allowedTypes = array('jpg','png','jpeg','gif','pdf');
            if(in_array($fileType, $allowedTypes))
            {
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath))
                {
                    if($stmt = $auth->databaseConnection->con->prepare('INSERT INTO files (type, name, added_by, created_at) VALUES (?,?,?,?)'))
                    {
                        $stmt->bind_param('ssis', $fileType, $fileName, $auth->user_id, $current_timestamp);
                        if($stmt->execute())
                        {
                            $last_id = mysqli_stmt_insert_id($stmt);
                            if(isset($_REQUEST['type'], $_REQUEST['id']))
                            {
                                if($_REQUEST['type'] == 'cover')
                                {
                                    if($stmt = $auth->databaseConnection->con->prepare('UPDATE library_books SET cover_image_id = ? where id = ?'))
                                    {
                                        $stmt->bind_param('ii', $last_id, $_REQUEST['id']);
                                        if($stmt->execute())
                                        {
                                            $STATUS_FLAG = 'SUCCESS';
                                            header("Location: /");
                                            die();
                                        }
                                    }
                                }
                            } 
                        }else{
                            $STATUS_FLAG = 'error while registering file to DB';
                            echo $STATUS_FLAG;
                        }
                    }else{
                        $STATUS_FLAG = 'error while registering file to DB';
                        echo $STATUS_FLAG;
                    }
                }else{
                    $STATUS_FLAG = 'error while uploading file to filesystem';
                    echo $STATUS_FLAG;
                }
            }else{
                $STATUS_FLAG = 'invalid file type';
                echo $STATUS_FLAG;
            }
        }else{
            $STATUS_FLAG = 'no file provided';
            echo $STATUS_FLAG;
        }
        echo $STATUS_FLAG;

?>