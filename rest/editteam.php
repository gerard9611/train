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
parse_str(file_get_contents("php://input"), $_PUT);
if(empty($_PUT['team_id']) || empty($_PUT['summary']))
{
	die('error');
}
$team_id = $_PUT['team_id'];
$summary = $_PUT['summary'];

$result = Team::editteam($team_id, $summary);
if($result > 0)
{
	echo 'success';
}
else
{
	die('error');
}
?>