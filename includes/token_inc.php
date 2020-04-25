<?php
session_start();
/*Connecting to the database*/
require 'dbh_inc.php';
/*Checking to see if a token was generated - a user decided to give his token*/
if(isset($_POST['tokenCode'])){
  $tokenCode= $_POST['tokenCode'];
  $fromUser= $_POST['fromUser'];
  $toUser= $_POST['toUser'];
  $book = str_replace("'","''",$_POST['book']);
  $status="in transaction";

 /*Making sure that the user doesn't give the same token twice.*/
$query= "SELECT * FROM tokenstatus WHERE fromUser='$fromUser' AND toUser='$toUser' AND book='$book' ";
$results = mysqli_query($conn, $query);
/*Let's see if there's a duplicate. If there isn't, we will insert the given information.*/
 if(!($row=mysqli_fetch_assoc($results))){
  		$query = "INSERT INTO tokenstatus (fromUser, toUser, status, tokenCode, book) 
  		VALUES('$fromUser', '$toUser', '$status', '$tokenCode', '$book')";
  		mysqli_query($conn, $query);
  		echo "none";
  	}
/*The user information exists already*/
 else{
 	$query= "SELECT tokenCode FROM tokenstatus WHERE fromUser='$fromUser' AND toUser='$toUser' AND book='$book' ";
 	$results=mysqli_query($conn, $query);
 	while ($row = mysqli_fetch_assoc($results)) {
			echo $row['tokenCode'];
		}

 }

}
