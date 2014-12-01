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
        
echo '<form method="POST">';
echo '<label>edit comment: </label><input type="text" name="comment"><br>';
echo '<input type="submit" name="submit" value="Update">';
echo '</form>';

if(isset($_POST["submit"])){       
$stmt = $mysqli->prepare("update comments set comment= ?,time=CURRENT_TIMESTAMP where comment_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('si', $_POST['comment'], $comment_id);

$stmt->execute();
 
$stmt->close();

header("Location: $comment_path");
}       
?>