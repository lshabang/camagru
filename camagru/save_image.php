<?php
session_start();
if (isset($_SESSION['uid']) && isset($_SESSION['email'])){

	if (isset($_POST['img']))
	{
        $image = $_POST['img'];
        $image = base64_decode($image);
		echo $image;
		require "config/setup.php";
		$sql = "INSERT INTO izithombe (username, email, igama, image) VALUES (:username, :email, :igama, :image)";
		try{
			$stmt = $pdo->prepare($sql);
			try{
				$username = $_SESSION['uid'];
                $email = $_SESSION['email'];
                $name = "photoby".$username;
				$stmt->execute(['username' => $username, 'email' => $email, 'igama' => $name, 'image' => $image]);
                echo "saved to db";
            }catch(PDOException $e){
				die ("couldnt execute ".$e->getMessage());
			}
		}catch(PDOException $e){
			die ("not prepared ".$e->getMessage());
		}
	}
}
?>