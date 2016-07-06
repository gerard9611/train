<?php
include_once('Person.php');
include_once('Project.php');

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
$project_id = $_POST['project_id'];
	$projects = Project::getProject($project_id);
	$json = json_encode($projects);
	$json = '{"projects":'.$json.'}';
	echo $json;
?>