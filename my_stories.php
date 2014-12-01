<?php
require 'database.php';
session_start();
$user_id=$_SESSION['user_id'];
$stmt = $mysqli->prepare("select link, title, username, time, story_id from stories where username='$user_id' order by time desc");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($link, $title, $submitter, $time, $story_id);
 
echo "<table>";
echo '<tr>';
echo '<th>Title</th>';
echo '<th>Submitter</th>';
echo '<th>Post time</th>';
echo '<th>Comments</th>';
echo '<th>Edit</th>';
echo '</tr>';
while($stmt->fetch()){
    echo '<tr>';
    echo '<td><a href="'.htmlentities($link).'"> '.htmlentities($title).'</a></td>';
    echo '<td>'.htmlentities($submitter).'</td>';
    echo '<td>'.$time.'</td>';
    $comment_path = sprintf("comments.php?story_id=%s", $story_id);
    echo '<td><a href="'.$comment_path.'"> Comments </a></td>';
    $delete_path = sprintf("delete_story.php?story_id=%s", $story_id);
    $edit_path = sprintf("edit_story.php?story_id=%s", $story_id);
    echo '<td><a href="'.$edit_path.'"> Edit Story </a></td>';
    echo '<td><a href="'.$delete_path.'"> Delete Story </a></td>';
    echo '</tr>';
}
echo "</table>";
 
$stmt->close();
?>