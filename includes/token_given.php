<?php
session_start();
/*Connecting to the database*/
require 'dbh_inc.php';
$fromUser = $_POST['wantedUser'];
$book = $_POST['wantedBook'];
$book = str_replace("'","''", $book);
$tokenCode = $_POST['tokenCode'];
$toUser =$_POST['toUsers'];
$query="SELECT * FROM tokenstatus WHERE fromUser='$fromUser' AND tokenCode='$tokenCode'";
$result=mysqli_query($conn, $query);
if($row=mysqli_fetch_assoc($result)){
	//need to check if the giver has a positive number of tokens.
	$query="SELECT * FROM users WHERE uidUsers='$fromUser' ";
	$result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($result)) {
		$tokNum = $row['tokUsers'];
	}
	// the giver has a positive number of tokens
	if($tokNum>0){
		$tokNum=$tokNum - 1;
		$query="UPDATE users SET tokUsers='$tokNum' WHERE uidUsers = '$fromUser'";
		mysqli_query($conn, $query);
		$query="SELECT tokUsers FROM users WHERE uidUsers='$toUser' ";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$tokNum = $row['tokUsers'];
		}
		$tokNum=$tokNum + 1;
		$query="UPDATE users SET tokUsers='$tokNum' WHERE uidUsers = '$toUser'";
		mysqli_query($conn, $query);
		$query= "DELETE FROM tokenstatus WHERE fromUser='$fromUser' AND tokenCode='$tokenCode' ";
		mysqli_query($conn, $query);
		$query= "DELETE FROM givesaway WHERE user='$toUser' AND book='$book'";
		mysqli_query($conn, $query);
		echo "success";
	}
	// the giver has no tokens to give
	else{
		echo "notokens";
	}

}
else{
	echo "wrongtoken";
}