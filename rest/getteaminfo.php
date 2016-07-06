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
	$teams = Team::getTeamInfo($team_id);
	$json = json_encode($teams);
	$json = '{"teams":'.$json.'}';
	echo $json;
?>