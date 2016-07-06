<?php

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
$project_id = $_POST['project_id'];
$team_id = $_POST['team_id'];
$members = Person::getMembers($project_id);

$out = '<table id="members"><tbody id="mtbody">';
foreach($members as $mem)
{
	$res = Person::checkTeam($team_id, $mem['person_id']);
	$out .= '<tr>';
	$out .= '<td>'.$mem['first_name'].' '.$mem['last_name'].'</td>';
	if($res == true)
		$out .= '<td><button onclick="btnRemove('.$team_id.', '.$mem['person_id'].', '.$project_id.')" id="btnedit" class="btn btn-danger">Remove</button></td>';
	else
		$out .= '<td><button onclick="btnAdd('.$team_id.', '.$mem['person_id'].', '.$project_id.')" id="btnedit" class="btn btn-warning">Add</button></td>';
	$out .= '</tr>';
}
$out .= '</tbody></table>';
echo $out;
?>