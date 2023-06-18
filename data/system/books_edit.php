<?php
    require "../auth/authenticate.php";
    $auth = new Authentication();
    Authentication::check_authentication($auth);

    if(isset($_REQUEST['book_id']))
    {
        $book_id = $_REQUEST['book_id'];
    }else{
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
    <title>Book | LIMS | v0.0.1</title>
    <?php
        if(isset($auth->session))
        {
            echo "<script async>var token = '", $auth->session->get('LIMS.auth'), "';</script>";
            echo "<script async>var book_id = '", $book_id, "';</script>";
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
            <div class="section">
                <span class="section-name">Settings</span>
                <a href="#somewhere" class="">Users</a>
                <a href="#somewhere" class="">Configuration</a>
                <a href="#somewhere" class="">Statistics</a>
            </div>
        </div>
    </div>
    <div id="system-body">
        <div class="header d-flex">
            <h1 id="book-title">{undefined book}</h1>
            <div>
                <a class="btn btn-danger" onclick="remove()">Delete</a>
            </div>
        </div>
        <div class="content d-flex-rows d-flex" id="books-content">
        <div id="book-cover-bg" class="book-cover-bg" style="background-image: url('https://images.penguinrandomhouse.com/cover/9788418915093');"></div>
            <div class="book-description">
                <h3>Book information</h3>
                <div class="" id="book-fields"></div>
                <a href="#update" class="mt-5 btn btn-primary" onclick="update();">Update</a>
            </div>
        </div>
    </div>
    <script src="books_edit.js"></script>
</body>
</html>