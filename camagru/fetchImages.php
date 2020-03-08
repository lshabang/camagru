<?php
include "config/setup.php";
session_start();
if (isset($_SESSION['uid']) && isset($_SESSION['email']))
{
	try{
		$countStart = $_POST['countStart'];
		$prd = $pdo->prepare('SELECT * FROM izithombe ORDER BY date_time DESC LIMIT :amount OFFSET :countStart');
		try{
			$amount = 3;
			$prd->bindValue(':amount', (int)$amount, PDO::PARAM_INT);
			$prd->bindValue(':countStart', (int)$countStart, PDO::PARAM_INT);
			$prd->execute();
			$all = array(array());
			$all[0] = array("fetchedAmount" => 0);
			$i = 1;
			while($rows = $prd->fetch(PDO::FETCH_ASSOC)){
				$all[$i] = array(	"id" => 		$rows['id'],
									"username" =>	$rows['username'],
									"email" => 		$rows['email'],
									"igama" =>		$rows['igama'],
									"image" => 		base64_encode($rows['image']),
									"date" =>		$rows['date_time']
								);
				$i++;
			}
			$i--;
			$all[0] = array ("fetchedAmount" => $i);
			echo (json_encode($all));
		}catch(PDOException $e){die("could not execute".$e->getMessage());}}catch(PDOException $e){die("could not prepare".$e->getMessage());}
}else{
	try{
		$countStart = $_POST['countStart'];
		$prd = $pdo->prepare('SELECT * FROM izithombe ORDER BY date_time DESC LIMIT :amount OFFSET :countStart');
		try{
			$amount = 3;
			$prd->bindValue(':amount', (int)$amount, PDO::PARAM_INT);
			$prd->bindValue(':countStart', (int)$countStart, PDO::PARAM_INT);
			$prd->execute();
			$all = array(array());
			$all[0] = array("fetchedAmount" => 0);
			$i = 1;
			while($rows = $prd->fetch(PDO::FETCH_ASSOC))
			{
				$all[$i] = array(	"username" =>	$rows['username'],
									"image" => 		base64_encode($rows['image']),
									"date" =>		$rows['date_time']
								);
				$i++;
			}
			$i--;
			$all[0] = array("fetchedAmount" => $i);
			echo (json_encode($all));
		}catch(PDOException $e){
			die("could not execute".$e->getMessage());
		}
	}catch(PDOException $e){
		die("could not prepare".$e->getMessage());
	}	
}
?>