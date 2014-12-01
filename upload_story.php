<?php
require 'database.php';
session_start();
$user_id=$_SESSION['user_id'];
$title = $_POST['title'];
$link = $_POST['link'];
 
$stmt = $mysqli->prepare("insert into stories (username, link, title) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->bind_param('sss', $user_id, $link, $title);
 
$stmt->execute();
 
$stmt->close();
echo '<head><meta http-equiv="refresh" content="3; URL=http://ec2-54-186-174-161.us-west-2.compute.amazonaws.com/~jia/module3/newsCenter.php">Upload suceessfully! Go back to previous page in 3 seconds</head>';
?>