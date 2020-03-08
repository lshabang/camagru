<?php

	session_start();
	if (isset($_SESSION['uid']) && isset($_SESSION['email']))
	{
		$img_id = $_GET['img_id'];
		require "config/setup.php";

		try{
			$stmt = $pdo->prepare('SELECT * FROM likes WHERE igama =:img_id');
			$stmt->execute(['img_id' => $img_id]);
			$i = 0;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$i++;
			}
			echo $i;
		}catch (PDOExecption $e){
			die ("couldnt get likes ".$e->getMessage());
		}
	}
?>