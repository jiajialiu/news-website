<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="mainpage.css">
		<title>Comments</title>
	</head>
	<body>
	<div class="main">
	<a href = "search.php" > <img src ="news.png" alt = "Welcome to newsCenter!" height="150" width="237"> </a>
<?php
require 'database.php';
session_start();
$user_id=$_SESSION['user_id'];
$story_id=(int)$_GET['story_id'];
$stmt = $mysqli->prepare("select comment_id, commenter, comment, time from comments where story_id='$story_id' order by time desc");
        if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
        }
         
        $stmt->execute();
         
        $stmt->bind_result($comment_id, $commenter, $comment, $time);
        
        echo "<table>";
	echo '<tr>';
	echo '<th>Comment</th>';
	echo '<th>Commenter</th>';
        echo '<th>Time</th>';
	echo '</tr>';
        while($stmt->fetch()){
            echo '<tr>';
	    echo '<td>'.htmlentities($comment).'</td>';
	    echo '<td>'.htmlentities($commenter).'</td>';
	    echo '<td>'.$time.'</td>';
	    if($commenter == $user_id){
		$edit_path = sprintf("edit_comment.php?story_id=%s&comment_id=%s", (string) $story_id, $comment_id);
                $delete_path = sprintf("delete_comment.php?story_id=%s&comment_id=%s", (string) $story_id, $comment_id);
		echo '<td><a href="'.$edit_path.'"> Edit Comment </a></td>';
                echo '<td><a href="'.$delete_path.'"> Delete Comment </a></td>';
	    } else {
		echo '<td></td>';
	    }
	    echo '</tr>';
        }
	echo "</table>";

        $stmt->close();
        echo '<br><br>';
        if (isset($user_id) && $user_id != "undefine"){
		echo '<form action = "post_comment.php" method = "POST">';
		echo '<input type = "hidden" name = "story_id" value = "'.$story_id.'">';
		echo 'Comment: <input type ="text" name = "comment">';
		echo '<input type ="submit" value ="Submit">';
		echo '</form>';
		echo '<br>';
		echo '<form method="POST" action="logout.php">';
		echo 'Click here to Logout: <input type="Submit" value="Logout" name="logout">';
		echo '</form>';
	} else {
		echo 'Please log in to comment';
	}
?>
        </div>
	</body>
</html>