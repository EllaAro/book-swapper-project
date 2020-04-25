<?php
if(isset($_POST['signup-submit'])){

	require "dbh_inc.php"; //connect to the database
	//fetch the submitted information by the user
	$username= $_POST['uid']; 
	$email= $_POST['mail'];
	$location= $_POST['location'];
	$password= $_POST['pwd'];
	$passwordRepeat= $_POST['pwd-repeat'];
	require 'tags/signup_tags.php'; //error handling
	mysqli_stmt_close($stmt); //closing off the statment
	mysqli_close($conn);
}
else{
	header("Location: ../index.php");
	exit();
}