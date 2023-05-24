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
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1L5.5 6.5" stroke="white" stroke-opacity="0.9" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M11 1L7.5 11L5.5 6.5L1 4.5L11 1Z" stroke="white" stroke-opacity="0.9"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Books</span>
                </a>
                <a href="#somewhere" class="">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1L5.5 6.5" stroke="white" stroke-opacity="0.9" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M11 1L7.5 11L5.5 6.5L1 4.5L11 1Z" stroke="white" stroke-opacity="0.9"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Leases</span>
                </a>
            </div>
            <div class="section">
                <span class="section-name">Settings</span>
                <a href="#somewhere" class="">Users</a>
                <a href="#somewhere" class="">Configuration</a>
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
                <a href="" class="btn btn-primary">New book</a>
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