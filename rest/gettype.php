<?php
include_once('Person.php');


$email = $_SERVER['HTTP_EMAIL'];
$pass = $_SERVER['HTTP_PASSWORD'];

if(Person::checkUser($email, $pass))
{
	$id = Person::getUserId($email);
}
else
{
	die('error');
}

	$persons = Person::getPerson($id);
	foreach($persons as $p)
	{
		if(strcmp($p['is_trainer'], '1') == 0)
		{
			echo 'trainer';
			exit;
		}
		else if(strcmp($p['is_admin'], '1') == 0)
		{
			echo 'admin';
			exit;
		}
		else
		{
			echo 'student';
			exit;
		}
	}
?>