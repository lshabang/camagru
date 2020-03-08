<!doctype html>
<html>
<head>
	<meta name="viewport" content="width= device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>Profile</title>
</head>
<body>
	<?php require "nav.php";
	if (!isset($_SESSION['uid'])){
		header("Location: index.php");
	}
	?>
	<div class="profile">
		<img id="proimg" src="user1.jpg">
		<?php
		if (isset($_SESSION['uid']))
		{
			require "config/setup.php";
			$username = $_SESSION['uid'];
			$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username =:name');
			$stmt->execute(['name' => $username]);
			$on_off;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$mail = $row['mail'];
				$rows = $row;
			}
			if ($mail == 0){
				$on_off = 'mail off';
				$color = 'red';
			}else if ($mail == 1){
				$on_off= 'mail on';
				$color = 'green';
			}
			echo '<h3>'.$_SESSION['uid'].'</h3><br>';
			echo '<div class="mailEdit"><a href="editprofile.php">Edit profile</a>';
			echo 	'<form method="POST" class="ama_email">
						<button type="submit" style="background-color:'.$color.';" name="submit">'.$on_off.'</button>
					</form></div>';
		}
		?>
	</div>
</body>
</html>

<?php
	if(isset($_SESSION['uid'])){
		if(isset($_POST['submit'])){
			require "config/setup.php";
			$username = $_SESSION['uid'];
			$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username =:name');
			$stmt->execute(['name' => $username]);
			$i = 0;
			$pass_fetch;
			$rows;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{		
				$mail = $row['mail'];
				$rows = $row;
				$i++;
			}
			if ($i < 0)
			{
				header("Location: login.php?error=Nousersfound");
				exit();
			}else{
				if ($mail == 1){
					try{
						$stmt = $pdo->prepare('UPDATE accounts SET mail = 0 WHERE username =:username');
					}catch (PDOExecption $e){
						die ("counldnt prepare ".$e->getMessage());
					}
					try{
						$stmt->execute(['username' => $username]);
						header("Location: profile.php?success=mailoff");
					}catch (PDOExecption $e){
						die ("counldnt execute ".$e->getMessage());
					}
				}else if ($mail == 0){
					try{
						$stmt = $pdo->prepare('UPDATE accounts SET mail = 1 WHERE username =:username');
					}catch (PDOExecption $e){
						die ("counldnt prepare ".$e->getMessage());
					}
					try{
						$stmt->execute(['username' => $username]);
						header("Location: profile.php?success=mailon");
					}catch (PDOExecption $e){
						die ("counldnt execute ".$e->getMessage());
					}
				}else
				{
					header("Location: index.php?msg=somethingwentwrong");
					die();
				}
			}
		}
	}
?>