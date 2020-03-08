<html>
<head>
	<meta name="viewport" content="width= device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>Photo</title>
</head>
<body>
	<?php require "nav.php";
		if (!isset($_SESSION['uid'])){
			header("Location: index.php");}	
	?>
	<div class="camera-box">
		<!-- video -->
		<div class="picture_center">
			<video id="video" playsinline autoplay width="350" height="300"></video>
			<canvas id="canvas" width="350" height="300" style="display: none;"></canvas>
			<img id="imgsrc" src="" alt="wentwrong" width="350" height="300" style="display: none;">
		</div>
		<!-- controls -->
		<div class="controls">
			<input type="file" name="file" id="file"class="buttons">
			<button id="upload" class="buttons">upload</button>
			<button id="snap" class="buttons">Capture</button>
			<button id="save" class="buttons1">Save</button>
			<button id="cancel" class="buttons1">cancel</button>
		</div>
		<!-- end controls -->
		<!-- stickers -->
		<div class="stickers"  id="stickers">
			<img src="stickers/flower.png" id="flower" class="sticker" draggable="true">
			<img src="stickers/star.png" id="star" class="sticker" draggable="true">
			<img src="stickers/sun.png" id="sun" class="sticker" draggable="true">
			<img src="stickers/heart.png" id="heart" class="sticker" draggable="true">
		</div>
		<!-- gif--->
		<div class="stickers" style="display:none;" id="gifs">
			<img src="stickers/gif/enter.gif" id="enter" class="sticker" draggable="true">
			<img src="stickers/gif/typical.gif" id="typical" class="sticker" draggable="true">
		</div>
		<!-- thumbnails -->
		<div class="thumbnails">
			<h6>previously edited</h6>
			<?php
				require "config/setup.php";
				try{
					$prd = $pdo->prepare('SELECT * FROM izithombe WHERE username=:username AND email=:email ORDER BY date_time DESC');
					try{
						$prd->execute(['username' => $_SESSION['uid'], 'email' => $_SESSION['email']]);
						$i = 0;
						if ($row = $prd->fetch(PDO::FETCH_ASSOC))
						{
							extract($row);
							$igama = $row['igama'];
							echo '<img height="60" width="75" src="data:image;base64,'.base64_encode($row['image']).'">';
							$i++;
						}
						if ($row = $prd->fetch(PDO::FETCH_ASSOC))
						{
							extract($row);
							$igama = $row['igama'];
							echo '<img height="60" width="75" src="data:image;base64,'.base64_encode($row['image']).'">';
							$i++;
						}
						if ($row = $prd->fetch(PDO::FETCH_ASSOC))
						{
							extract($row);
							$igama = $row['igama'];
							echo '<img height="60" width="80" src="data:image;base64,'.base64_encode($row['image']).'">';
							$i++;
						}
					}catch(PDOException $e){
						die ("execute fail".$e->getMessage());
					}
				}catch(PDOException $e){
					die ("prepare failed ".$e->getMessage());
				}
			?>
		</div>
	</div>
	<footer class="foooter">lshabang</footer>
	<script src="photo.js"></script>
</body>
</html>

<script>
	
</script>



