<?php

class db
{
	function db_connect()
	{
		$dbDatabase="training_center";
		$host = 'localhost';
		$user = 'root';
		$pass = 'root';
		
		$conn = new PDO("mysql:host=$host;dbname=$dbDatabase", $user, $pass);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    return $conn;

	}
	function db_close()
	{
		mysql_close();
	}
}
?>




































