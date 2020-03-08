<?php
	if (isset($_POST['submit']))
	{
	   	require "config/setup.php";
		$username = $_POST['username'];
		$email = $_POST['email'];
		$pass = $_POST['password'];		
		if (empty($username) || empty($email) || empty($pass))
		{
			header("Location: login.php?error=emptyfields&username=".$username."&email=".$email);
			exit();
		}else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
			header("Location: login.php?error=invalidusername&username=".$username);
			exit();
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("Location: login.php?error=invalidemail&username=".$email);
			exit();
		}
		else
		{
			$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username =:name AND email=:email');
			$stmt->execute(['name' => $username, 'email' => $email]);
			$i = 0;
			$pass_fetch;
			$rows;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pass_fetch = $row['password'];
				$active = $row['active'];
				$rows = $row;
				$i++;
			}
			if ($i < 0)
			{
				header("Location: login.php?error=Nousersfound");
				exit();
			}else{
				$pass_check = password_verify($pass, $pass_fetch);
				
				if ($pass_check == false)
				{
					header("Location: login.php?error=wrongpassword&username=".$username."&email=".$email);
					exit();
				}else if ($active == 0){
					header("Location: login.php?error=youarenotaconfirmeduser");
					exit();					
				} else if ($pass_check == true){
					session_start();
					$_SESSION['uid'] = $rows['username'];
					$_SESSION['email'] = $rows['email'];
					header("Location: profile.php?yourareloggedin");
					exit();
				}else
				{
					header("Location: login.php?error");
					exit();
				}
			}
		}
	}
?>
<html>
<head>
	<meta name="viewport" content="width= device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>Camagru | sign in</title>
</head>
<body>

	<form class="form" method="POST">
		<h1>Camagru<h1>
		<h2>Sign in</h2>
		<input type="text" name="username" placeholder="Username" class="tbx">
		<input type="text" name="email" placeholder="Email" class="tbx">
		<input type="password" name="password" placeholder="Password" class="tbx">
		<input type="submit" name="submit" value="login">
		<p class="u_sub"><a href="forgot_pass.php" >Forgot password</a></p>
		<p class="u_sub"><a href="signup.php">Dont have account</a></p>
	</form>
</body>
</html>