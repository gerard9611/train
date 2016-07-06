<?php

include_once('Person.php');
include_once('Team.php');

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

$person_id = $_REQUEST['person_id'];
$team_id = $_REQUEST['team_id'];
$result = Team::removeMember($person_id,$team_id);
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