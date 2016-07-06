<?php

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
if(!isset($_REQUEST['class_id']) || !isset($_REQUEST['subject']) || !isset($_REQUEST['title']) || !isset($_REQUEST['deadline']))
{
	die('error');
}
$class_id = $_REQUEST['class_id'];
$subject = $_REQUEST['subject'];
$title = $_REQUEST['title'];
$deadline = $_REQUEST['deadline'];


$result = Project::insertProject($owner_id,$class_id, $subject, $title, $deadline);
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