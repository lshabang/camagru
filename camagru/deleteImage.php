<?php
	if (isset($_SESSION['uid']) && sisset($_SESSION['email']))
	{
		$username = $_SESSION['uid'];
		$email = $_SESSION['email'];
		if (isset($_POST['delete']))
		{
			$id = $_POST['id'];
			require "config/setup.php";
			try{
				$stmt = $pdo->prepare('DELETE FROM izithombe WHERE id=:id');
				try{
					$stmt->execute(['id' => $id]);
					header("Location: gallary.php?success=picdeleted");
				}catch(PDOExecption $e){
					die ("couldnt prepare ".$e->getMessage());
				}
			}catch(PDOExecption $e){
				die ("couldnt prepare ".$e->getMessage());
			}
		}
	}
?>