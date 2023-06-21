<?php
    require "../auth/authenticate.php";
    $auth = new Authentication();
    Authentication::check_authentication($auth);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/ui/main.css">
    <title>Leases | LIMS v2.0</title>
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
                <a href="/system/index.php" id="nav-books-link">
                    <span>Books</span>
                </a>
                <a href="/system/leases_view.php" class="active">
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
                        echo '<a href="/system/users.php" class="">All users</a>';
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

    <div class="topnav">
        <div class="search-area">
            <input type="text" class="form-control" placeholder="Search here...">
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
            <h1>
                <?php
            if($auth->role == 1)
                    {
                        echo 'All issued books';
                    }else{
                        echo 'My issued books';
                    }
                    ?>
            </h1>
        </div>
        <div class="content" id="books-content">
            <div class="divTable" style="width: 100%;">
                <div class="divTableBody" id="leases-rows">
                </div>
            </div>
        </div>
    </div>

<script src="/assets/js/leases.js"></script>
<script src="/assets/js/search.js"></script>
</body>
</html>