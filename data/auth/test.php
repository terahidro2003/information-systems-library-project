<?php
require "LoginFactory.php";

ob_start();
session_start();


$login = new LoginFactory("lew@lew.lew", "!HelloWorld2003");
$login->validate();
$login->authenticate();
?>