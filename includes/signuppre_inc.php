<?php
session_start();
/*Connecting to the database*/
require 'dbh_inc.php';
$uidUsers = $_POST['uidUsers'];
$emailUsers = $_POST['emailUsers'];
$pwdUsers = $_POST['pwdUsers'];
$repwdUsers = $_POST['repwdUsers'];
//let's make sure that the user doesn't use the same username
$sql1="SELECT uidUsers FROM users WHERE uidUsers=?";
$stmt1 = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt1,$sql1);
mysqli_stmt_bind_param($stmt1,"s",$uidUsers);
mysqli_stmt_execute($stmt1);
mysqli_stmt_store_result($stmt1);
$resultCheck1 = mysqli_stmt_num_rows($stmt1);

//let's make sure that the sure doesn't use the same email
$sql2="SELECT emailUsers FROM users WHERE emailUsers=?";
$stmt2 = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt2,$sql2);
mysqli_stmt_bind_param($stmt2,"s",$emailUsers);
mysqli_stmt_execute($stmt2);
mysqli_stmt_store_result($stmt2);
$resultCheck2 = mysqli_stmt_num_rows($stmt2);

//let's make sure that the email is valid
if(!filter_var($emailUsers, FILTER_VALIDATE_EMAIL)){
	echo 'invalidemail';
}
//let's make sure that both of the passwords match
else if ($pwdUsers !== $repwdUsers){
	echo "notmatchingpw";
}

else if($resultCheck1>0){
	echo "takenname";
}


else if($resultCheck2>0){
	echo "takenemail";
}

else{
	echo "success";
}
 


