<?php
    $DB_DSN = "mysql:host=localhost";
    $DB_USER = "root";
    $DB_PASSWORD = "123456";
	
	try{
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		try{
			$pdo->exec("CREATE DATABASE camagru");
		}catch (PDOException $e)
		{
			die("database was not created ".$e->getMessage()."<br>");
		}
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e){
		die("failed to connect ". $e->getMessage());
	}
?>