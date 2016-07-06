<?php

include_once('Team.php');
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
$team_id = $_POST['team_id'];
	$members = Person::getTeamMembers($team_id);
	$json = json_encode($members);
	$json = '{"members":'.$json.'}';
	echo $json;
?>