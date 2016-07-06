<?php

include_once('db.php');

class Classe
{
	function getClasses()
	{
		$conn = db::db_connect();
		$stmt = $conn->prepare('SELECT * FROM class');
		$stmt->execute();
		$tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);
		db::db_close();
		return $tmp;
	}
}

?>