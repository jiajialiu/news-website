<?php
require 'database.php';
session_start();
$story_id = (int)$_GET['story_id'];

$stmt = $mysqli->prepare("select username, link, title from stories where story_id = '$story_id'");
        if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
        }
         
        $stmt->execute();
         
        $stmt->bind_result($submitter, $link, $title);
        
        $stmt->fetch();

        if($submitter != $_SESSION['user_id']){
            header("Location: search.php");
        }
        
        $stmt->close();

echo '<form method="POST">';
echo '<label>renew the link: </label><input type="text" name="link" value="'.htmlentities($link).'"><br>';
echo '<label>renew the title: </label><input type="text" name="title" value="'.htmlentities($title).'"><br>';
echo '<input type="submit" name="submit" value="Update">';
echo '</form>';

if(isset($_POST["submit"])){
$link=$_POST['link'];
$title=$_POST['title'];
$stmt = $mysqli->prepare("update stories set link=?, title=?,time=CURRENT_TIMESTAMP where story_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('ssi', $link, $title, $story_id);
 
$stmt->execute();
 
$stmt->close();
header("Location: search.php");
}
?>