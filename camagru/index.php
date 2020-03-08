<?php
	session_start();
?>
<html>
<head>
	<meta name="viewport" content="width= device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>index</title>
</head>
<body>
	<div class="home">
		<h1>Camagru<h1>
		<?php
			if (isset($_SESSION['uid'])){
				echo	'<div id="indexLinks">
							<a href="posts.php" class="ha">home</a>
							<a href="gallary.php" class="ha">gallary</a>
							<a href="logout.php" class="ha">logout</a>
						</div>';
			}else{
				echo	'<div id="indexLinks">
							<a href="login.php" class="ha">Sign In</a>
							<a href="signup.php" class="ha">Sign Up</a>
							<a href="posts.php" class="ha">Posts</a>
						</div>';
			}
		?>
	</div>
</body>
</html>