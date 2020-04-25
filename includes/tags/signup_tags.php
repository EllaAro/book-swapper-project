<?php
$sql= "INSERT INTO users (uidUsers, emailUsers, pwdUsers, locUsers) VALUES (?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
	header("Location: ../index.php?error=sqlerror");
	exit();
}
else{
	$hashedPwd= password_hash($password, PASSWORD_DEFAULT);
	mysqli_stmt_bind_param($stmt,"ssss",$username, $email, $hashedPwd, $location);
	mysqli_stmt_execute($stmt);
	header("Location: ../index.php?index=success");
	exit();
}