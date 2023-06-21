<?php

require "LoginFactory.php";

$login = new LoginFactory();
if(!$login->auth(false, null))
{
   header('Location: /index.php');
   exit();
}else{
    $login->session->clear();
    header('Location: /index.php');
   exit();
}

?>