<?php
	session_start();
	session_unset('uid');
	session_unset('email');
	session_destroy();
	header("Location: index.php?status=loggout");
?>