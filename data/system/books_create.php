<?php
    require "../auth/authenticate.php";
    $auth = new Authentication();
    
    Authentication::check_authentication($auth);


    /*
     If user is not an admin user, redirect back
    */
    if($auth->role != 1)
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

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

<?php

    if($auth->role == 1)
    {
        echo '<body class="admin-panel">';
        echo '<script async>var is_admin = true;</script>';
    }else{
        echo '<body>';
        echo '<script async>var is_admin = false;</script>';
    }
    
?>
    <dialog class="search-dialog" id="search-dialog" closed>
        <p>Search results:</p>
        <div id="search-results-panel">

        </div>
    </dialog>

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
                <a href="/system/index.php" id="nav-books-link" class="active">
                    <span>Books</span>
                </a>
                <a href="/system/leases_view.php">
                <?php
                    if($auth->role == 1)
                    {
                        echo 'All issued books';
                    }else{
                        echo 'My issued books';
                    }
                ?>
                </a>
            </div>
            <div class="section">
                <span class="section-name">Settings</span>
                <?php
                    if($auth->role == 1)
                    {
                        echo '<a href="" class="">All users</a>';
                    }
                ?>
                <a href="/system/statistics.php" class="">Statistics</a>
            </div>
        </div>
    </div>

    <div class="topnav">
        <div class="search-area">
            <input type="text" class="form-control" id="search-input" onfocus="opensearchdialog();" placeholder="Search here...">
        </div>
        <div class="d-flex d-flex-inline d-flex-align-center">
            <?php
              if(isset($auth->email))
              {
                  echo $auth->email;
              }   
            ?>
            <form action="/auth/logout.php" method="post">
                <button type="submit" class="ml-9 btn" style="border: 1px dashed #ddd;">Logout</button>
            </form>
        </div>
    </div>
    <div id="system-body">
        <div class="header d-flex">
            <h1 id="book-title">{undefined book}</h1>
            <div>
                <h4>Phase 1: General Book Information</h4>
                <a onclick="fill_google_books_api()" class="btn btn-primary">Try Fetch Google Books API</a>
            </div>
            
        </div>
        <div class="alert alert-warning">
            Please note that once a book can be created as either physical or either electronical. The book type can be changed after creation, however it would be impossible to retrieve PDF file or add PDF file.
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
    <script src="/assets/js/books_create.js"></script>
    <script src="/assets/js/search.js"></script>
</body>
</html>