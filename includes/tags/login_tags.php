<?php 
if(empty($userUid) && empty($password)){
	header("Location: ../index.php?error=emptyfieldlogin");
	exit();
	}
if(empty($userUid)){
	header("Location: ../index.php?error=emptyusernamelogin");
	exit();
}
if(empty($password)){
	header("Location: ../index.php?error=emptypwdlogin&userUid=".$userUid);
	exit();
}
else{
	$sql= "SELECT * FROM users WHERE uidUsers=?";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		header("Location: ../index.php?error=sqlerror");
		exit();
	}
	else{
		mysqli_stmt_bind_param($stmt, "s", $userUid);
		mysqli_stmt_execute($stmt);
		$result=mysqli_stmt_get_result($stmt);
		if($row =mysqli_fetch_assoc($result)){
			$pwdCheck= password_verify($password,$row['pwdUsers']);
			if($pwdCheck== false){
				header("Location: ../index.php?error=wrongpwdlogin");
				exit();
			}
			else if( $pwdCheck== true){
				session_start();
				$_SESSION['userId'] = $row['idUsers'];
				$_SESSION['userUid'] =$row['uidUsers'];
				header("Location: ../index.php?login=success"); //we're heading to the next page!!! we have logged in
				exit();
			}

		}
		else{
			header("Location: ../index.php?error=nouserlogin");
			exit();
		}
	}

}