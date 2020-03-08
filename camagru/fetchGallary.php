<?php
	session_start();
	if (isset($_SESSION['uid']) && isset($_SESSION['email']))
	{
		$username = $_SESSION['uid'];
		$email = $_SESSION['email'];
		$countStart = $_POST['countStart'];
		require "config/setup.php";
		try{
			$prd = $pdo->prepare('SELECT * FROM izithombe WHERE username=:username AND email=:email ORDER BY date_time DESC LIMIT :amount OFFSET :countStart');
			$amount = 3;
			$prd->bindParam('username', $username);
			$prd->bindParam('email', $email);
			$prd->bindValue('amount', (int)$amount, PDO::PARAM_INT);
			$prd->bindValue('countStart', (int)$countStart, PDO::PARAM_INT);
			try{
				$prd->execute();
				$all = array(array());
				$all[0] = array('fetchAmount' => 0);
				$i = 1;
				while($rows = $prd->fetch(PDO::FETCH_ASSOC)){
					$all[$i] = array("id" => $rows['id'],
										"username" =>	$rows['username'],
										"email" => 		$rows['email'],
										"igama" =>		$rows['igama'],
										"image" => 		base64_encode($rows['image']),
										"date" =>		$rows['date_time']
										);
					$i++;
				}
				$i--;
				$all[0] = array('fetchedAmount' => $i);
				echo (json_encode($all));
			}catch(PDOException $e){
				die("could not execute".$e->getMessage());
			}
		}catch(PDOException $e){
			die("could not prepare".$e->getMessage());
		}
	}
?>