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
$project_id = $_POST['project_id'];

$res = Project::deleteProject($project_id);
if($res>0)
	echo 'success';
else
	echo 'error';
?>