<html>
<head>
	<meta name="viewport" content="width= device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css.css">
	<title>Comments</title>
</head>
<body>
	<?php
		require "nav.php";
		session_start();
		if (!isset($_SESSION['uid'])){
			header("Location:index.php");
		}
	?>
	<div class="comment">
		<?php
			if (isset($_GET['id']) && isset($_SESSION['uid']) && isset($_SESSION['email'])){
				require 'config/setup.php';
				$id = $_GET['id'];
				$imageby = $_GET['imageby'];
				try{
					$stmt = $pdo->prepare('SELECT * FROM comments WHERE imageid =:imageid');
					$stmt->execute([":imageid" => $id]);
					$i = 0;
					$allcomments = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach ($allcomments as $comment){
						echo	'<div class="commentbox">
									<h6 class="commenter">'.$comment['username'].'</h6>
									<p class="thecomment">"'.$comment['comment'].'"</p>
								</div>';
					}
				}catch(PDOException $e){
					header("Location:post.php?couldnt_get_comments");
				}
			}
		?>
		<form class="commentarea" method="POST" action="comment.php">
			<input type="text" name="imageid" value="<?php echo $id?>" style="display: none;">
			<input type="text" name="imageby" value="<?php echo $imageby?>" style="display: none;">
			<textarea name="comment" cols="30" rows="10"></textarea>
			<button type="submit" name="submit">comment</button>
		</form>
	</div>
</body>
</html>