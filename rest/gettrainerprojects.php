<?php
include_once('Person.php');
include_once('Project.php');


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

	$projects = Project::getTrainerProjects($person_id);
	$json = json_encode($projects);
	$json = '{"projects":'.$json.'}';
	echo $json;
?>