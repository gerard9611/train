<?php

include_once('Project.php');
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
$projects = Project::getProjects($id);
$json = json_encode($projects);
$json = '{"projects":'.$json.'}';
echo $json;
?>