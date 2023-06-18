<?php
    require "../auth/authenticate.php";
    $auth = new Authentication();
    
    Authentication::check_authentication($auth);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/ui/main.css">
    <title>New Book | LIMS | v0.0.1</title>
    <?php
        if(isset($auth->session))
        {
            echo "<script async>var token = '", $auth->session->get('LIMS.auth'), "';</script>";
        }
    ?>
</head>
<body>
<div class="topnav">
        <div class="search-area">
            <input type="text" class="form-control" placeholder="Search here...">
        </div>
        <div>
            <?php
              if(isset($auth->email))
              {
                  echo $auth->email;
        
              }   
              if(isset($role))
              {
                echo $role;
              }
            ?>
        </div>
    </div>
<div class="sidenav">
        <div class="logo" style="color: #fff;">
            <div style="text-align: center;">
                LIMS
                <br />
                <span style="font-size: 8px;">
                    Hello, 
                    <?php
                    if(isset($auth->email))
                    {
                        echo $auth->email;
                    }
                    ?>
                </span>
            </div>
        </div>
       
        <div class="sidenav-content">
            <div class="section">
                <span class="section-name">Library</span>
                <a href="#somewhere" class="active" id="nav-books-link">
                    <span>Books</span>
                </a>
                <a href="#somewhere" class="">
                    <span>My Leases</span>
                </a>
                <a href="#somewhere" class="">
                    <span>My Ebooks</span>
                </a>
            </div>
            <div class="section">
                <span class="section-name">Settings</span>
                <a href="#somewhere" class="">Security</a>
                <a href="#somewhere" class="">Statistics</a>
            </div>
        </div>
    </div>
    <div id="system-body">
        <div class="header d-flex">
            <h1 id="book-title">{undefined book}</h1>
            <h4>Phase 1: General Book Information</h4>
        </div>
        <div id="alert-success" style="display: none;" class="mt-8 mb-8 alert alert-success">
            Book information saved successfully
        </div>
        <div id="alert-error" style="display: none;" class="mt-8 mb-8 alert alert-danger">
            Failed to save book information. Please check fields and if unsuccessfull contact system administrator.
        </div>
        <div id="alert-validation" style="display: none;" class="mt-8 mb-8 alert alert-warning">
            Please fill all mandatory fields.
        </div>
        <div class="content">
        <div class="book-description" id="phase1">
                <div class="d-flex-rows d-flex d-flex-align-center d-justify-between d-wrap" id="book-fields"></div>
                <a href="#create" class="mt-5 btn btn-primary" onclick="create();">Save</a>
        </div>
        <div id="file-upload-panel" class="book-cover-bg d-flex d-flex-align-center"  style="background-color: #f4f4f4;display: none;">
            <form method="POST" action="/system/file_api.php" enctype="multipart/form-data">
                    <div>
                        <h3 style="text-align: center;">Upload cover image image here</h3>
                        <input name="type" type="text" value="cover" hidden>
                        <input name="id" type="text" id="book-id" hidden>
                        <input name="file" type="file" accept="image/jpeg, image/png, image/jpg" name="book-cover-image">
                    </div>
                        <button type="submit" class="btn btn-primary">Upload cover</button>
            </form>
        </div>
            
        </div>
    </div>
    <script src="books_create.js"></script>
</body>
</html>