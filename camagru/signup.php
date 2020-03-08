<?php
   if (isset($_POST['submit'])){
	   	require "config/setup.php";
		$username = $_POST['username'];
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$pass_v = $_POST['password_v'];
		
		if (empty($username) || empty($email) || empty($pass) || empty($pass_v)){
			header("Location: signup.php?error=emptyfields&username=".$username."&email=".$email);
		}else if (strlen($username) < 4){
			header("Location: signup.php?error=username_to_short&email=".$email);
		}else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("Location: signup.php?error=invalidusername");
		}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("Location: signup.php?error=invalidemail&username=".$username);	
		}else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
			header("Location: signup.php?error=invalidusername&username=".$username);
		}else if ($pass !== $pass_v){
			header("Location: signup.php?error=invalidusername&username=".$username."&email=".$email);
		}else if (strlen($pass) < 4){
			header("Location: signup.php?error=password_to_short&email=".$email);
		}else{
			$stmt = $pdo->prepare('SELECT * FROM accounts WHERE username =:name');
			$stmt->execute(['name' => $username]);
			$i = 0;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$i++;
			}
			if ($i > 0){
				header("Location: signup.php?error=userinfotaken");
			}else{
				$hashed = password_hash($pass, PASSWORD_DEFAULT);
				$active = 0;
				$sql = "INSERT INTO accounts (username, email, password, active, mail) VALUES (:username, :email, :pass, :active, 1)";
				try{
					$statement = $pdo->prepare($sql);
					$statement->execute(['username' => $username, 'email' => $email , 'pass' => $hashed, 'active' => $active]);
					$link = "http://localhost:8080/camagru/confirm_signup.php?msg=success&username=".$username."&email=".$email;
					$subject = 'confirm your registration with camagru';
					$msg = "<h1>confirm</h1><p>click this link to confirm <a href=".$link.">".$link."</a></p>";
					$header = "Content-type: text/html\r\n";
					$result = mail($email, $subject, $msg, $header);
					header("Location: index.php?success=yousignedupcheckyourmail");
				}catch (PDOException $e){
				   die("couldnt execute ". $e->getMessage());
				}
			}
		}
   }
?>
<head>
	<meta name="viewport" content="width= device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>sign up</title>
</head>
<body>
	<form class="form" method="POST">
		<h1>Camagru</h1>
		<h2>Sign up</h2>
		<input type="text" name="username" placeholder="Username" class="tbx">
		<input type="email" name="email" placeholder="Email" class="tbx">
		<input type="password" name="password" placeholder="Password" class="tbx" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
		<input type="password" name="password_v" placeholder="Confirm password" class="tbx" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
		<input type="submit" name="submit" value="confirm">
		<div class="u_sub"><a href="login.php">sign in</a></div>
	</form>
</body>