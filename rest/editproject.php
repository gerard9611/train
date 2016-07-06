<?php
/**
NOT USER ANYMORE
*/
include_once('Person.php');
include_once('Project.php');

$email = $_SERVER['HTTP_EMAIL'];
$pass = $_SERVER['HTTP_PASSWORD'];


if(Person::checkUser($email, $pass))
{
	$owner_id = Person::getUserId($email);
}
else
{
	die('error');
}
parse_str(file_get_contents("php://input"), $_PUT);
$project_id = $_PUT['project_id'];
$title = $_PUT['title'];
$subject = $_PUT['subject'];
$deadline = $_PUT['deadline'];
if(empty($_PUT['project_id']) || empty($_PUT['title']) || empty($_PUT['subject']) || empty($_PUT['deadline']))
{
	die('error');
}
$result = Project::editProject($project_id, $title, $subject, $deadline);
if($result > 0)
{
	echo 'success';
}
else
{
	die('error');
}
?>