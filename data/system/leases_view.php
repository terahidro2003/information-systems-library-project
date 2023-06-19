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
        echo '<script async> var is_admin = true; </script>';
    }else{
        echo '<body>';
        echo '<script async> var is_admin = false; </script>';
    }
    
?>
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
                        echo 'All leases';
                    }else{
                        echo 'My Leases';
                    }
                ?>
                </a>
                <a href="#somewhere" class="">
                <?php
                    if($auth->role == 1)
                    {
                        echo 'All Ebooks';
                    }else{
                        echo 'My Ebooks';
                    }
                ?>
                </a>
            </div>
            <div class="section">
                <span class="section-name">Settings</span>
                <a href="#somewhere" class="">Security</a>
                <?php
                    if($auth->role == 1)
                    {
                        echo '<a href="" class="">All users</a>';
                        echo '<a href="" class="">Login Histories</a>';
                    }
                ?>
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
            <h1>
                <?php
            if($auth->role == 1)
                    {
                        echo 'All leases';
                    }else{
                        echo 'My leases';
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

<script src="leases.js"></script>
</body>
</html>