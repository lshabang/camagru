<?php
	session_start();
	
	if (isset($_SESSION['uid']) && isset($_SESSION['email']))
	{
		
		$username = $_SESSION['uid'];
		$email = $_SESSION['email'];
		if (isset($_POST['img1']) && isset($_POST['img2']))
		{
			$img1 = "data:image/jpeg;base64,".$_POST['img1'];
			if($img1 = imagecreatefromjpeg($img1))
			{
				imagealphablending($img1, true);
				if($img2 = imagecreatefrompng($_POST['img2']))
				{
					list($width, $height) = getimagesize($_POST['img2']);
					if(imagecopy($img1, $img2,10,10,0,0,$width,$height))
					{
						imagejpeg($img1, "img.jpeg");
						ob_start(); // Let's start output buffering.
							imagejpeg($img1); //This will normally output the image, but because of ob_start(), it won't.
							$contents = ob_get_contents(); //Instead, output above is saved to $contents
						ob_end_clean(); //End the output buffer.
						$dataUri = "data:image/jpeg;base64," . base64_encode($contents);
						echo $dataUri;
					}else{
						echo "nun was done";
					}
				}else{
					echo "image 2 not created";
				}
			}else{
				echo "image 1 not created";
			}
			imagedestroy($img1);
			
		}
	}
?>