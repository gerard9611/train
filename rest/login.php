<?php

include_once('Person.php');


$email = $_REQUEST['email'];
$pass = $_REQUEST['pass'];
$result = Person::login($email, $pass);
foreach ($result as $row)
{
	if((int)$row['cou']>0)
	{
		echo 'success';
	}
	else
	{
		echo 'error';
	}
}
?>