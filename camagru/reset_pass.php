<?php
	$email = $_GET['email'];
	$username = $_GET['username'];
   if (isset($_POST['submit']))
   {
		$pass = $_POST['password'];
		$pass_v = $_POST['password_v'];
		
		
		if (empty($pass) || empty($pass_v)){
			header("Location: reset_pass.php?error=emptyfield");
			exit();
		}else if ($pass !== $pass_v){
			header("Location: reset_pass.php?error=passwordsnotsame");
			exit();
		}else if (strlen($pass) < 4){
			header("Location: reset_pass.php?error=password_to_short");
			exit();
		}else{
			require "config/setup.php";
			try{
				$stmt = $pdo->prepare('UPDATE accounts SET password=:pass WHERE email=:email AND username=:username');
			}catch (PDOExecption $e){
				die ("counldnt prepare ".$e->getMessage());
			}
			try{
				$hashed = password_hash($pass, PASSWORD_DEFAULT);
				$stmt->execute(['pass' => $hashed,'email' => $email, 'username' => $username]);
				header("Location: index.php?success=passwordchangesuccess");
			}catch (PDOExecption $e){
				die ("counldnt execute ".$e->getMessage());
			}
		}
   }
?>
<head>
	<meta name="viewport" content="width= device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>reset password</title>
</head>
<body>
	<form class="form" method="POST">
		<h1>Camagru</h1>
		<h2>reset password</h2>
		<input type="password" name="password" placeholder="New password" class="tbx">
		<input type="password" name="password_v" placeholder="Confirm password" class="tbx">
		<input type="submit" name="submit" value="confirm">
	</form>
</body>