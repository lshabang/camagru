<?php
	session_start();
	if (isset($_SESSION['uid']) && isset($_SESSION['email']))
	{
		$username = $_SESSION['uid'];
		$email = $_SESSION['email'];
		require "config/setup.php";

		try{
			$prd = $pdo->prepare('SELECT * FROM izithombe ORDER BY date_time DESC LIMIT 2, 2');
			try{
				$prd->execute();
				$all = array(array());
				$i = 0;
				while($rows = $prd->fetch(PDO::FETCH_ASSOC))
				{
					$all[$i] = array(	"id" => $rows['id'],
										/*"date" => $rows['date_time']*/
									);
					$i++;
				}
				var_dump($all);
			}catch(PDOException $e){
				die("could not execute".$e->getMessage());
			}
		}catch(PDOException $e){
			die("could not prepare".$e->getMessage());
		}
	}
?>