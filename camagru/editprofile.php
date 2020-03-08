<?php
	session_start();
	if (isset($_SESSION['uid']))
	{
		require "config/setup.php";
		
		try{
			$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username =:username');
		}catch (PDOExecption $e){
			die ("coudnt prepare ".$e->getMessage());	
		}
		try{
			$stmt->execute(['username' => $_SESSION['uid']]);
		}catch(PDOExecption $e){
			die ("coudnt execute ".$e->getMessage());
		}
		$i = 0;
		$rows;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$rows = $row;
			$i++;
		}
		if ($i == 1 && $rows['username'] == $_SESSION['uid'] && $rows['email'] == $_SESSION['email'])
		{
			if (isset($_POST['change_username']))
			{
				$username = $_POST['username'];
			
				if (empty($username))
				{
					header("Location: editprofile.php?error=usernameempty");
				}else
				{
					if (strlen($username) < 4){
						header("Location: editprofile.php?error=username_to_short");
						exit();
					}else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
						header("Location: editprofile.php?error=invalidusername");
						exit();
					}else{
						try{
						$stmt = $pdo->prepare('UPDATE accounts SET username=:username WHERE username=:username_i');
						$stmt->execute(['username' => $username, 'username_i' => $_SESSION['uid']]);

						$stmt = $pdo->prepare('UPDATE comments SET username=:username WHERE username=:username_i');
						$stmt->execute(['username' => $username, 'username_i' => $_SESSION['uid']]);

						$stmt = $pdo->prepare('UPDATE izithombe SET username=:username WHERE username=:username_i');
						$stmt->execute(['username' => $username, 'username_i' => $_SESSION['uid']]);

						$stmt = $pdo->prepare('UPDATE likes SET username=:username WHERE username=:username_i');
						$stmt->execute(['username' => $username, 'username_i' => $_SESSION['uid']]);

						$_SESSION['uid'] = $username;
						header("Location: profile.php?usernamechanged");
						}catch(PDOExecption $e){
							die ("coudnt execute ".$e->getMessage());
						}
					}
				}
			}
			if (isset($_POST['change_email'])){
				$email = $_POST['email'];
			
				if (empty($email))
				{
					header("Location: editprofile.php?error=emptyemail");
				}else
				{
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
						header("Location: editprofile.php?error=invalidemail");
						exit();
					}else{
						try{
							$stmt = $pdo->prepare('UPDATE accounts SET email=:email WHERE username=:username_i');
							$stmt->execute(['email' => $email, 'username_i' => $_SESSION['uid']]);

							$stmt = $pdo->prepare('UPDATE izithombe SET email=:email WHERE username=:username_i');
							$stmt->execute(['email' => $email, 'username_i' => $_SESSION['uid']]);

							$_SESSION['email'] = $email;
							header("Location: profile.php?emailchanged");
						}catch (PDOExecption $e){
							die ("coudnt execute ".$e->getMessage());
						}
					}
				}
			}
			
			if (isset($_POST['change_password'])){
				$pass = $_POST['password'];
				$pass_v = $_POST['password_v'];
			
				if (empty($pass) || empty($pass_v))
				{
					header("Location: editprofile.php?error=emptyfields");
				}else
				{				
					if ($pass !== $pass_v){
						header("Location: editprofile.php?error=invalidusername&username=".$username."&email=".$email);
						exit();
					}else if (strlen($pass) < 4){
						header("Location: editprofile.php?error=password_to_short&email=".$email);
						exit();
					}else{
						$hashed = password_hash($pass, PASSWORD_DEFAULT);
						$stmt = $pdo->prepare('UPDATE accounts SET password=:password WHERE username=:username');
						$stmt->execute(['password' => $hashed , 'username' => $_SESSION['uid']]);
						header("Location: profile.php?passwordchanged");
					}
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
	<title>Edit profile</title>
</head>
<body>
	<form class="form" method="POST">
		<h2>Edit profile</h2>
		<input type="text" name="username" placeholder="username" class="tbx"><input type="submit" name="change_username" value="Change username">
		<input type="text" name="email" placeholder="Email" class="tbx"><input type="submit" name="change_email" value="Change email">
		<input type="password" name="password" placeholder="Password" class="tbx" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
		<input type="password" name="password_v" placeholder="Confirm password" class="tbx" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><input type="submit" name="change_password" value="change password">
		<br><br>
        <a href="profile.php" style="margin: 10px;padding: 15px; background:none;text-decoration:none; border: 0;">back</a>
		<a href="logout.php" style="margin: 10px;padding: 15px;background:none;text-decoration:none; border: 0;">logout</a>
	</form>
</body>
</html>
<script>
	console.log("this logg");
</script>