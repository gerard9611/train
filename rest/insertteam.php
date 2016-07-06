<?php

include_once('Person.php');
include_once('Team.php');

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
if(!isset($_REQUEST['project_id']) || !isset($_REQUEST['summary']))
{
	die('error');
}
$project_id = $_REQUEST['project_id'];
$summary = $_REQUEST['summary'];
$result = Team::insertTeam($owner_id,$project_id, $summary);
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