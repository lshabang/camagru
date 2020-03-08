<?php

	require "database.php";
	$DB_DSN = "mysql:host=localhost;dbname=camagru;charset=utf8mb4";

	try{
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	}catch (PDOException $e){
		die("coulndt connect ".$e->getMessage());
	}

	//$pdo->setAttribute(PDO::ERRMODE_EXCEPTION);
	try{
		$pdo->exec("CREATE TABLE IF NOT EXISTS accounts(
			id INT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			username varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			password varchar(255) NOT NULL,
			active INT(2) NOT NULL,
			mail INT(2) NOT NULL
			);");
	}catch (PDOException $e){
		die("table was not created ".$e->getMessage());
	}

	try
	{
		$pdo->exec("CREATE TABLE IF NOT EXISTS izithombe (
			id INT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			username varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			igama varchar(255) NOT NULL,
			image LONGBLOB NOT NULL,
			date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			);");
	}catch (PDOException $e){
		die("table izithombe was not created ".$e->getMessage());
	}

	try{
		$pdo->exec("CREATE TABLE IF NOT EXISTS comments (
			id INT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			imageid INT(100) NOT NULL,
			igama varchar(255) NOT NULL,
			username varchar(255) NOT NULL,
			comment varchar(255) NOT NULL,
			date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			);");
	}catch (PDOException $e){
		die("table comments was not created ".$e->getMessage());
	}


	try{
		$pdo->exec("CREATE TABLE IF NOT EXISTS likes (
			id INT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			heart INT(100) NOT NULL,
			igama varchar(255) NOT NULL,
			username varchar(255) NOT NULL,
			date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			);");
	}catch (PDOException $e){
		die("table likes was not created ".$e->getMessage());
	}

?>