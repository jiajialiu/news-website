<!DOCTYPE html>
<html>
	<head>
		<title>newsCenter</title>
		<link rel="stylesheet" type="text/css" href="mainpage.css">
	</head>
	<body>
	<div class="main">
	<div class="float_left">
	<a href = "newsCenter.php" > <img src ="news.png" alt = "Welcome to news center!" height="150" width="237"> </a>
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
		echo '<input type = "password" name = "password" value = "password">';
		echo '<input type = "submit" value = "Create New User">';
		echo '</form>';
		echo '</div>';
		echo '<br><br><br><br><br><br><br><br><br><br>Sign in to upload a story or comment';
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
		echo '<br><br><br><br><br><br><br><br><br><br><br><br>';
		}
		
	?>
	</div>
	</body>
</html>