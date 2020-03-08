

<?php

	session_start();
	if (isset($_SESSION['uid']) && isset($_SESSION['email']))
	{
		$img_id = $_GET['img_id'];
		require "config/setup.php";
		$liker = $_SESSION['uid'];
		$liker_email = $_SESSION['email'];

		$stmt = $pdo->prepare('SELECT * FROM likes WHERE username =:name AND igama =:img_id');
		$stmt->execute(['name' => $liker, 'img_id' => $img_id]);
		$i = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$i++;
		}
		if ($i > 0)
		{
			try{
				$stmt = $pdo->prepare('DELETE FROM likes WHERE igama =:img_id AND username =:username');
				$stmt->execute(['img_id' => $img_id, 'username' => $liker]);
				echo 0;
				exit();
			}catch(PDOExecption $e){
				die ("couldnt prepare ".$e->getMessage());
			}
		}
		else{
			try{
				$stmt = $pdo->prepare('INSERT INTO likes (heart, igama, username) VALUES (1, :img_id ,:img_uid )');
				$stmt->execute(['img_id' => $img_id, 'img_uid' => $liker]);
				echo 1;
				exit();
			}catch(PDOExecption $e){
				die ("couldnt prepare ".$e->getMessage());
			}
		}
	}
?>