<?php

include_once('Person.php');

$firstname = $_REQUEST['firstname'];
$lastname = $_REQUEST['lastname'];
$address = $_REQUEST['address'];
$zip = $_REQUEST['zip'];
$town = $_REQUEST['town'];
$email = $_REQUEST['email'];
$mobile = $_REQUEST['mobile'];
$phone = $_REQUEST['phone'];
$password = $_REQUEST['password'];
$res = Person::registerUser($firstname, $lastname, $address, $zip, $town, $email, $mobile, $phone, $password);
if($res>0)
	echo 'success';
else
	echo 'error';


?>