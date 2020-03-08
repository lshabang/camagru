<?php

   if (isset($_POST['submit']))
   {
		$username = $_POST['username'];
		$email = $_POST['email'];
		
		if (empty($email) || empty($username))
		{
			header("Location: forgot_pass.php?error=emptyfieldss");
			exit();
		}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("Location: signup.php?error=invalidemail");
			exit();
		}else
		{
			require "config/setup.php";
			try{
				$stmt = $pdo->prepare('SELECT * FROM accounts WHERE email =:email AND username=:username');
			}catch(PDOException $e){
				die ("counldnt prepare ".$e->getMessage());
			}
			try{
				$stmt->execute(['email' => $email, 'username' => $username]);
			}catch(PDOException $e){
				die ("counldnt execute ".$e->getMessage());
			}
			$i = 0;
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$db_email = $row['email'];
				$active = $row['active'];
				$i++;
			}
			if ($i < 0)
			{
				header("Location: forgot_pass.php?error=nosuchuser");
				exit();
			}else{
				if ($active == 1)
				{
					$to = $db_email;
					$link = "http://localhost:8080/camagru/reset_pass.php?email=".$email."&username=".$username;
					$subject = 'reset your password';
					$msg = "<h1>Reset password</h1><p>click this link to reset your pass <a href=".$link.">".$link."</a></p>";
					
					$header = "From: lindani <shabangulindani516@gmail.com>\r\n";
					$header .= "Replay-to: lshabang@student.wethinkcode.co.za\r\n";
					$header .= "Content-type: text/html\r\n";
					$result = mail($to, $subject, $msg, $header);
					header("Location: forgot_pass.php?msg=emailsent&email=".$email);
					exit();
				}else
				{
					header("Location: index.php?msg=confirmsignupinemail");
					exit();
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
	<title>forgot password</title>
</head>
<body>
	<form class="form" method="POST">
		<h1>Camagru</h1>
		<h2>forgot password</h2>
        <h5 style="color:grey;padding: 20px;">Please enter you email and username, so a link can be sent to your email. With the link sent you will able to change your password</h5>
		<input type="text" name="username" placeholder="username" class="tbx">
		<input type="email" name="email" placeholder="Email" class="tbx">
		<input type="submit" name="submit" value="confirm">
		<p class="u_sub"><a href="login.php">sign in</a></p>
		<?php
			if($_POST['msg'] == 'emailsent'){
				echo '<h5 style="color:grey;padding: 20px;">email sent</5>';
			}
			?>
	</form>
</body>
