<?php

include_once('db.php');

class Team
{

	function insertTeam($owner_id, $project_id, $summary)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("INSERT INTO team
			(owner_id, project_id, summary)
			VALUES 
			(:f1, :f2, :f3)");
		$stmt->bindValue(':f1', $owner_id, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $project_id, PDO::PARAM_STR);
		$stmt->bindValue(':f3', $summary, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		
		db::db_close();
		return $tmp;
	}
	function editTeam($team_id, $summary)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("UPDATE team SET
			summary=:f2 WHERE team_id=:f1");
		$stmt->bindValue(':f1', $team_id, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $summary, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		
		db::db_close();
		return $tmp;
	}

	function deleteTeam($team_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("DELETE FROM team WHERE
			team_id=:f1");
		$stmt->bindValue(':f1', $team_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		
		db::db_close();
		return $tmp;
	}

	function getTeams($id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT * FROM team WHERE owner_id=:f1");
		$stmt->bindValue(':f1', $id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		return $tmp;
	}

	function addMember($person_id,$team_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("INSERT INTO team_member
			(team_id, student_id)
			VALUES 
			(:f1, :f2)");
		$stmt->bindValue(':f1', $team_id, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $person_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		db::db_close();
		return $tmp;
	}

	function removeMember($person_id,$team_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("DELETE FROM team_member WHERE
			team_id=:f1 AND student_id=:f2");
		$stmt->bindValue(':f1', $team_id, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $person_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		db::db_close();
		return $tmp;
	}

	function getTeamInfo($team_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT * FROM team INNER JOIN project ON team.project_id=project.project_id INNER JOIN person ON team.owner_id=person.person_id WHERE team.team_id=:f1");
		$stmt->bindValue(':f1', $team_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		return $tmp;
	}
}

?>