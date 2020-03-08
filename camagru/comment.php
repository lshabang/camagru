<?php
    session_start();
    if (isset($_POST['submit']) && isset($_SESSION['uid'])){
        $comment = htmlspecialchars($_POST['comment']);
        $imageid = $_POST['imageid'];
        $username = $_SESSION['uid'];
        $igama = $_POST['imageby'];
        require "config/setup.php";
        try{
            $stmt = $pdo->prepare("INSERT INTO comments (imageid, igama, username, comment) VALUES (:imageid, :igama, :username, :comment)");
            $stmt->execute(["imageid" => $imageid, "igama" => $igama, "username" => $username, "comment" => $comment]);
        }catch(PDOException $e){
            header("Location:comments.php?id=".$imageid."&imageby=".$igama."&+somethingwentwrong");
        }
        try{
            $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username =:username");
            $stmt->execute(['username' => $igama]);

            $mail = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $to = $mail[0]['email'];
            $mail = $mail[0]['mail'];
            if ($mail == 1){
                $subject = 'Comment';
                $msg = "<h1>New comment</h1><p> From :::: ".$username.", saying ".$comment."</p>";
                $header = "Content-type: text/html\r\n";
                $result = mail($to, $subject, $msg, $header);
                header("Location:comments.php?id=".$imageid."&imageby=".$igama);
            }else if ($mail == 0){
                header("Location:comments.php?id=".$imageid."&imageby=".$igama."&+mailoff");
            }else{
                exit();}
        }catch(PDOException $e){
            header("Location:comments.php?id=".$imageid."&imageby=".$igama."&+somethingwentwrong");
        }
    }else{
        header("Location:posts.php");
    }