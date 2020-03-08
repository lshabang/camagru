<?php
session_start();
if (isset($_SESSION['uid']) && isset($_SESSION['email'])){
	echo "1";
}else{
	echo "0";
}
?>