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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,500;0,600;0,700;1,400;1,500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sidenav {
            width: 12.5rem;
            height: 100vh;
            position: fixed;
            background: #111130;

            padding-top: 2.5rem;
        }


        .sidenav .logo {
            padding-bottom: 3.438rem;
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            margin: 0 auto;
        }

        .section {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 3rem;
        }

        .section .section-name {
            color: #999999;
            opacity: .6;
            text-transform: uppercase;
            font-size: 0.663rem;
            padding-left: 1.2rem;
            margin-bottom: 0.4rem;
        }

        .section a {
            text-decoration: none;
            color: #ddd;
            background-color: transparent;
            padding: 0.75rem 1.2rem;
            margin: 0.325rem 0;
            font-size: 0.813rem;
        }

        .section a svg {
            margin-right: .75rem;
        }

        .section .active {
            background-color: #262642;
        }
    </style>
    <title>Dashboard | LIMS | v0.0.1</title>
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
                <span class="section-name">Library Managament</span>
                <a href="#somewhere" class="">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1L5.5 6.5" stroke="white" stroke-opacity="0.9" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M11 1L7.5 11L5.5 6.5L1 4.5L11 1Z" stroke="white" stroke-opacity="0.9"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Physical Inventory</span>
                </a>
                <a href="#somewhere" class="active">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1L5.5 6.5" stroke="white" stroke-opacity="0.9" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M11 1L7.5 11L5.5 6.5L1 4.5L11 1Z" stroke="white" stroke-opacity="0.9"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>E-books</span>
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
</body>

</html>