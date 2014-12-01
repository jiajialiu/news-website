<!DOCTYPE html>
<html>
	<head>
		<title>Search Results</title>
		<link rel="stylesheet" type="text/css" href="mainpage.css">
	</head>
	<body>
	<div class="main">
	<div class="float_left">
	<a href = "newsCenter.php" > <img src ="news.png" alt = "Welcome to newsCenter!" height="150" width="237"> </a>
	<form method = "post" action="search.php">
	<label>Search: </label>
	<input type="text" name = "search" >
	<label>Search By: </label>
	<select name="sort_by">
	<option value="time">Posted Time</option>
	<option value="user">Submitter</option>
	</select>
	<input type ="submit" value ="Search">
	</form>

	<?php
	session_start();

		if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] == "undefine")) {
		$_SESSION['user_id'] = "undefine";
		echo '</div>';
		echo '<div class = "sign_in">';
		echo '<h1>Log In</h1>';
		echo '<form action = "login.php" method = "POST">';
		echo '<input type ="text" name = "username" value = "username" maxlength="30">';
		echo '<input type = "password" name = "password" value = "password">';
		echo '<input type = "submit" value = "Log In">';
		echo '</form>';
		echo '<h1>New User</h1>';
		echo '<form action = "newuser.php" method = "POST">';
		echo '<input type ="text" name = "username" value = "username" maxlength="30">';
		echo '<input type = "password" name = "password"  value="password">';
		echo '<input type = "submit" value = "Create New User">';
		echo '</form>';
		echo '</div>';
		echo '<br><br><br><br><br><br><br><br><br><br>Sign in to upload a story or comment:';
		}
		else {
		$user_id = $_SESSION['user_id'] ;
		echo "Hello ". htmlentities($user_id). "!";
		echo '</div>';
		echo '<div class = "sign_in">';
		
		echo '<h1> Upload Story</h1>';
		echo '<form action = "upload_story.php" method = "POST">';
		echo 'Title: <input type ="text" name = "title" maxlength="300">';
		echo '<br>';
		echo 'Link: <input type = "text" name = "link" maxlength="500" >';
		echo '<input type ="submit" value ="Upload">';
		echo '</form>';
		
		echo '<form action = "my_stories.php" method = "POST" >';
		echo '<label>View stories I have posted: </label>';
		echo '<input type="submit" name = "viewmystories" value="view">';
	        echo '</form>';
		
		echo '<form method="POST" action="logout.php">';
		echo '<input type="Submit" value="Logout" name="logout">';
		echo '</form>';
		echo '</div>';
		echo '<br><br><br><br><br><br><br><br><br><br>';
		}
	require 'database.php';

	$sort_by = $_POST['sort_by'];
        $search = $_POST['search'];
        
        $stmt = $mysqli->prepare("select COUNT(*) from stories where  title like '%$search%'");
	if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}

	$stmt->execute();

	$stmt->bind_result($count);

	while($stmt->fetch()){
		$result_count = $count;
	}

	$stmt->close();

	if($result_count == 0){
	echo '<br><br><br>This query returned no results';
	} else {
            echo '<br><br><br>Here are your search results:';
        }
        
	if($sort_by == "time"||!isset($sort_by)){
	$stmt = $mysqli->prepare("select link, title, username, time, story_id from stories where title like '%$search%' order by time desc");
	}  else if ($sort_by == "user") {
		$stmt = $mysqli->prepare("select link, title, username, time, story_id from stories where username='$search' order by username");
	}

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
	echo '</tr>';
	while($stmt->fetch()){
			echo '<tr>';
			echo '<td><a href="'.htmlentities($link).'"> '.htmlentities($title).'</a></td>';
			echo '<td>'.htmlentities($submitter).'</td>';
			echo '<td>'.$time.'</td>';
			$comment_path = sprintf("comments.php?story_id=%s", $story_id);
			echo '<td><a href="'.$comment_path.'"> Comments </a></td>';
			if($submitter == $_SESSION['user_id']){
				$delete_path = sprintf("delete_story.php?story_id=%s", $story_id);
				$edit_path = sprintf("edit_story.php?story_id=%s", $story_id);
				echo '<td><a href="'.$edit_path.'"> Edit Story </a></td>';
				echo '<td><a href="'.$delete_path.'"> Delete Story </a></td>';
			} else {
				echo '<td></td>';
			}
			echo '</tr>';
	}
	echo "</table>";
	$stmt->close();


	?>
	</div>
	</body>
</html>