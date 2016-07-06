<?php
session_start();

$email = $_REQUEST['email'];
$pass = $_REQUEST['pass'];

$_SESSION['email'] = $email;
$_SESSION['pass'] = $pass;

?>