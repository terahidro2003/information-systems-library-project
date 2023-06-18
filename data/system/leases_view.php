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
                <a href="/system/index.php" id="nav-books-link">
                    <span>Books</span>
                </a>
                <a href="/system/leases_view.php" class="active">
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
            <h1>My leases</h1>
        </div>
        <div class="content" id="books-content">
            <div class="divTable" style="width: 100%;">
                <div class="divTableBody">
                    <div class="divTableRow divTableHeaderRow">
                        <div class="divTableCell">&nbsp;ID</div>
                        <div class="divTableCell">Book Title </div>
                        <div class="divTableCell">Author </div>
                        <div class="divTableCell">Leased from </div>
                        <div class="divTableCell">Deadline </div>
                        <div class="divTableCell">Authorized by </div>
                        <div class="divTableCell">Status</div>
                    </div>
                    <div class="divTableRow">
                        <div class="divTableCell">&nbsp; 81</div>
                        <div class="divTableCell">&nbsp; 1984</div>
                        <div class="divTableCell">&nbsp;
                            George Orwell
                        </div>
                        <div class="divTableCell">&nbsp;
                            2023-02-12 12:51:32
                        </div>
                        <div class="divTableCell">&nbsp;
                            2023-03-12 12:51:32
                        </div>
                        <div class="divTableCell">&nbsp;
                            J. Skarbalius
                        </div>
                        <div class="divTableCell">&nbsp;
                            Pending
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>