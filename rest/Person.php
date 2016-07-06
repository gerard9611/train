<?php

include_once('db.php');

class Person
{
	function login($email, $pass)
	{
		try
		{
			$conn = db::db_connect();
			$result = $conn->query("SELECT count(*)  as cou FROM person WHERE email LIKE '$email' AND password LIKE '$pass' LIMIT 1");
			db::db_close();
			return $result;
		}
		catch(PDOException $ex) 
		{
			echo 'error';
	   		//handle me.
		}
	}
	function registerUser($firstname, $lastname, $address, $zip, $town, $email, $mobile, $phone, $password)
	{
		$conn = db::db_connect();
		$regcode = md5(uniqid(rand(), true));
		$stmt = $conn->prepare("INSERT INTO person 
			(first_name, last_name, address, zip_code, town, email, mobile_phone, phone, password, confirmation_token)
			VALUES 
			(:f1, :f2, :f3, :f4, :f5, :f6, :f7, :f8, :f9, :f10)");
		$stmt->bindValue(':f1', $firstname, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $lastname, PDO::PARAM_STR);
		$stmt->bindValue(':f3', $address, PDO::PARAM_STR);
		$stmt->bindValue(':f4', $zip, PDO::PARAM_STR);
		$stmt->bindValue(':f5', $town, PDO::PARAM_STR);
		$stmt->bindValue(':f6', $email, PDO::PARAM_STR);
		$stmt->bindValue(':f7', $mobile, PDO::PARAM_STR);
		$stmt->bindValue(':f8', $phone, PDO::PARAM_STR);
		$stmt->bindValue(':f9', $password, PDO::PARAM_STR);
		$stmt->bindValue(':f10', $regcode, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->rowCount();
		
		db::db_close();
		return $tmp;
	}
	function getUserId($email)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT * FROM person WHERE email LIKE :f1 LIMIT 1");
		$stmt->bindValue(':f1', $email, PDO::PARAM_STR);
	 	$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		$id = 0;
		foreach($tmp as $p)
		{
			$id = $p['person_id'];
		}
		return $id;
	}

	function checkUser($email, $pass)
	{
		$result = Person::login($email, $pass);
		foreach ($result as $row)
		{
			if((int)$row['cou']>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function getPerson($person_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT * FROM person WHERE person_id=:f1");
		$stmt->bindValue(':f1', $person_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		return $tmp;
	}

	function getMembers($project_id)
	{
		$conn = db::db_connect();
		//$stmt = $conn->prepare("SELECT * FROM person INNER JOIN class_member ON person.person_id=class_member.person_id LEFT JOIN team_member ON person.person_id=team_member.student_id WHERE class_member.class_id=(SELECT class_id FROM project WHERE project_id=:f1)");
		$stmt = $conn->prepare("SELECT * FROM person INNER JOIN class_member ON person.person_id=class_member.person_id WHERE class_member.class_id=(SELECT class_id FROM project WHERE project_id=:f1)");
		$stmt->bindValue(':f1', $project_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		return $tmp;
	}

	function checkTeam($team_id, $person_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT count(*)  as cou FROM team_member WHERE team_id=:f1 AND student_id=:f2 LIMIT 1");
		$stmt->bindValue(':f1', $team_id, PDO::PARAM_STR);
		$stmt->bindValue(':f2', $person_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		foreach ($tmp as $row)
		{
			if((int)$row['cou']>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function getTeamMembers($team_id)
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare("SELECT * FROM person INNER JOIN team_member ON team_member.student_id=person.person_id WHERE team_member.team_id=:f1");
		$stmt->bindValue(':f1', $team_id, PDO::PARAM_STR);
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		return $tmp;
	}
}

?>