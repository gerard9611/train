<?php
include_once('Person.php');
include_once('Classe.php');


$email = $_SERVER['HTTP_EMAIL'];
$pass = $_SERVER['HTTP_PASSWORD'];

if(Person::checkUser($email, $pass))
{
	$person_id = Person::getUserId($email);
}
else
{
	die('error');
}

	$classes = Classe::getClasses();
	$json = json_encode($classes);
	$json = '{"classes":'.$json.'}';
	echo $json;
?>