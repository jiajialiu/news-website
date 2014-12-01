<?php
session_start();
require 'database.php';


// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), username, password_encrypted FROM users WHERE username=?");
 
// Bind the parameter
$stmt->bind_param('s', $user);
$user = $_POST['username'];
$stmt->execute();
 
// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
 
$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash
if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
	// Login succeeded!
	$_SESSION['user_id'] = $user_id;
        $_SESSION['token'] = substr(md5(rand()), 0, 10);
	header('Location: newsCenter.php');
        ;
}else{
	echo "Username not exist or wrong password";
        echo  '<a href="http://ec2-54-186-174-161.us-west-2.compute.amazonaws.com/~jia/module3/newsCenter.php"> Go Back</a>';
}

?>