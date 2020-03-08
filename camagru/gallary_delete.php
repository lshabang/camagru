<?php
session_start();
if (isset($_SESSION['uid']) && isset($_SESSION['email']))
{
	$id =  $_GET['id'];
	require "config/setup.php";
	try{
		$stmt = $pdo->prepare('DELETE FROM izithombe WHERE id=:id');
		$stmt->execute(['id' => $id]);
		header("Location: gallary.php?success=picdeleted");
	}catch(PDOExecption $e){
		die ("couldnt delete image ".$e->getMessage());
	}
}
?>