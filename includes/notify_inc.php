<?php
session_start();
/*Connecting to the database*/
require 'dbh_inc.php';
//current user
$currUser= $_SESSION['userUid'];
$content=array();
$offerNum= 0;

/*Getting the number of tokens of the current user*/
$query="SELECT * FROM users WHERE uidUsers='$currUser'";
$results= mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($results)){
	$currTokens= $row['tokUsers'];;
}
/*Getting all of the users that offer a token in exchange*/
$query="SELECT * FROM tokenstatus WHERE toUser='$currUser'";
$results= mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($results)){
	array_push($content,$row);
	$offerNum++;
}
