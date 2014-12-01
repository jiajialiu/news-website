<?php
require 'database.php';
session_start();
$story_id = $_GET['story_id'];
$comment_id = (int)$_GET['comment_id'];
$username = $_SESSION['user_id'];
$comment_path = sprintf("comments.php?story_id=%s", $story_id);
$stmt = $mysqli->prepare("select commenter from comments where comment_id = '$comment_id'");
if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
        }
         
        $stmt->execute();
         
        $stmt->bind_result($commenter);
        
        $stmt->fetch();

        if($commenter != $username){
            header("Location: $comment_path");
            exit;
        }

        $stmt->close();
        
$stmt = $mysqli->prepare("delete from comments where comment_id='$comment_id'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->close();

header("Location: $comment_path");
?>