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
$person_id = $_POST['person_id'];
	$persons = Person::getPerson($person_id);
	$json = json_encode($persons);
	$json = '{"persons":'.$json.'}';
	echo $json;
?>