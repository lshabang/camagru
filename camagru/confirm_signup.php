<?php
	if (isset($_POST['submit']))
	{
		require "config/setup.php";
		$username = $_GET['username'];
		$email = $_GET['email'];
		$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username =:name AND email=:email');
		$stmt->execute(['name' => $username, 'email' => $email]);
		$i = 0;
		$rows;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$rows = $row;
			$i++;
		}
		if ($i < 0)
		{
			header("Location: index.php?error=couldntconfirm");
			exit();
		}else{
			try{
				$stmt = $pdo->prepare('UPDATE accounts SET active =1 WHERE username=:username');
			}catch (PDOException $e){
				die("couldnt update ".$e->getMessage());
			}
			try{
				$stmt->execute(['username' => $username]);
				session_start();
				$_SESSION['uid'] = $username;
				$_SESSION['email'] = $email;
				header("Location: profile.php?msg=success");
			}catch (PDOException $e){
				die("couldnt execute ".$e->getMessage());
			}
		}
	}
?>

<head>
	<meta name="viewport" content="width= device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>camagru</title>
</head>
<body>
	<form class="form" method="POST">
		<h1>Camagru</h1>
		<h5>click to continue</h5><br><br>
		<input type="submit" name="submit" value="Qubeka">
	</form>
</body>
