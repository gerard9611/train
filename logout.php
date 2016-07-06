<?php
session_start();
$_SESSION['uid'] = "0";
session_destroy();
header('Location: index.php');

?>