<?php 
if(isset($_POST['login-submit'])){
	//connect to the data base
	require 'dbh_inc.php';
	$userUid = $_POST['userUid'];
	$password= $_POST['pwdUid'];
	require 'tags/login_tags.php';
	}
else {
	header("Location: ../index.php");
	exit();
}