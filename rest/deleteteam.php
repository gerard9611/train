<?php
include_once('Person.php');
include_once('Team.php');


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
$team_id = $_POST['team_id'];
$res = Team::deleteTeam($team_id);
if($res>0)
	echo 'success';
else
	echo 'error';
?>