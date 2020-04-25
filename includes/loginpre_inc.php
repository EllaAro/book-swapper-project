<?php
session_start();
/*Connecting to the database*/
require 'dbh_inc.php';
$uidUsers = $_POST['uidUsers'];
$pwdUsers = $_POST['pwdUsers'];

//let's make sure that the user exists
$sql= "SELECT * FROM users WHERE uidUsers=?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt,$sql);
mysqli_stmt_bind_param($stmt, "s", $uidUsers);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
$row =mysqli_fetch_assoc($result);
//let's make sure that the password is valid
$pwdCheck= password_verify($pwdUsers,$row['pwdUsers']);

if(!($row)){
	echo "nouser";
}

else if($pwdCheck== false){
	echo "wrongpwd";
}

else{
	echo "success";
}