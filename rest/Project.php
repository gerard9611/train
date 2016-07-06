<?php

include_once('db.php');

class Project
{
	function getProjects($id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT * FROM project INNER JOIN class_member ON project.class_id=class_member.class_id WHERE class_member.person_id=:f1");
		$stmt->bindValue(':f1', $id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		//var_dump($tmp);
		return $tmp;
	}
	function getTrainerProjects($person_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT * FROM project WHERE owner_id=:f1");
		$stmt->bindValue(':f1', $person_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		return $tmp;
	}

	function deleteProject($project_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("DELETE FROM project WHERE
			project_id=:f1");
		$stmt->bindValue(':f1', $project_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		
		db::db_close();
		return $tmp;
	}

	function insertProject($owner_id,$class_id, $subject, $title, $deadline)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("INSERT INTO project
			(owner_id, class_id, subject, title, deadline)
			VALUES 
			(:f1, :f2, :f3, :f4, :f5)");
		$stmt->bindValue(':f1', $owner_id, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $class_id, PDO::PARAM_STR);
		$stmt->bindValue(':f3', $subject, PDO::PARAM_STR);
		$stmt->bindValue(':f4', $title, PDO::PARAM_STR);
		$stmt->bindValue(':f5', $deadline, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		
		db::db_close();
		return $tmp;
	}
	/**
	NOT USER ANYMORE
	*/
	function editProject($project_id, $title, $subject, $deadline)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("UPDATE project SET
			subject=:f2, title=:f3, deadline=:f4 WHERE project_id=:f1");
		$stmt->bindValue(':f1', $project_id, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $subject, PDO::PARAM_STR);
		$stmt->bindValue(':f3', $title, PDO::PARAM_STR);
		$stmt->bindValue(':f4', $deadline, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		
		db::db_close();
		return $tmp;
	}

	function getProject($project_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT * FROM project INNER JOIN class ON project.class_id=class.class_id WHERE project.project_id=:f1");
		$stmt->bindValue(':f1', $project_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		return $tmp;
	}
}

?>