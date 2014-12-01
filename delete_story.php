<?php
require 'database.php';
session_start();
$story_id = (int)$_GET['story_id'];

$stmt = $mysqli->prepare("select username from stories where story_id = '$story_id'");
        if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
        }
         
        $stmt->execute();
         
        $stmt->bind_result($submitter);
        
        $stmt->fetch();

        if($submitter != $_SESSION['user_id']){
            header("Location: search.php");
        }
        
        $stmt->close();
 
$stmt = $mysqli->prepare("delete from stories where story_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('s', $story_id);
 
$stmt->execute();
 
$stmt->close();
header("Location: search.php");
?>