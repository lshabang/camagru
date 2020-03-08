<?php
	session_start();
	
	if (isset($_SESSION['uid'])){
		echo	'<nav class=nav nav-top>
				<ul>
				<li><a href="posts.php">home</a></li>
				<li><a href="gallary.php">zithombe</a></li>
				<li><a href="photo.php">Camera</a></li>
				<li><a href="profile.php">profile</a></li>
				<li><a href="logout.php">logout</a></li>
				</ul>
				</nav>';
	}else{
		echo	'<nav class=nav nav-top>
				<ul>
				<li><a href="login.php">signin</a></li>
				<li><a href="signup.php">signup</a></li>
				</ul>
				</nav>';
	}
?>
