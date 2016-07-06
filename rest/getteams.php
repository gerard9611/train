<?php

include_once('Team.php');
include_once('Person.php');


$email = $_SERVER['HTTP_EMAIL'];
$pass = $_SERVER['HTTP_PASSWORD'];

// print_r($_SERVER);
// echo $email;
if(Person::checkUser($email, $pass))
{
	$id = Person::getUserId($email);
	// echo $id;
	$teams = Team::getTeams($id);
	$json = json_encode($teams);
	$json = '{"teams":'.$json.'}';
	echo $json;
}
else
{
	echo 'error';
}

?>