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
    <title>Dashboard | LIMS | v0.0.1</title>
    <?php
        if(isset($auth->session))
        {
            echo "<script async>var token = '", $auth->session->get('LIMS.auth'), "';</script>";
        }
    ?>
</head>

<body>
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

    <div id="system-body">
        <div class="header d-flex">
            <h1>Books</h1>
            <div>
                <a href="books_create.php" class="btn btn-primary">New book</a>
            </div>
        </div>
        <div class="content" id="books-content">
            <div class="row" id="cards-row">
                
            </div>
        </div>
    </div>
    <script src="books.js"></script>
</body>

</html>