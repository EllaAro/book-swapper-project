<?php
session_start();
/*Connecting to the database*/
require 'dbh_inc.php';
$user=$_POST['user'];
$book=$_POST['book'];
$genre1=$_POST['opt1'];
$genre2=$_POST['opt2'];
$book =str_replace("'","''",$book);
 /*Making sure that the user doesn't tag twice.*/
 $query= "SELECT * FROM genres WHERE book='$book' AND user='$user'";
 $results = mysqli_query($conn, $query);
/*Let's see if there's a duplicate.*/
if(!($row=mysqli_fetch_assoc($results))){
		if($genre1!=""){
			$query = "INSERT INTO genres (user, book, genre) 
			VALUES('$user', '$book', '$genre1')";
			mysqli_query($conn, $query);
		}
		if($genre2!=""){
			$query = "INSERT INTO genres (user, book, genre) 
			VALUES('$user', '$book', '$genre2')";
			mysqli_query($conn, $query);
		}
		echo "success";
  	}
/*The user information exists already*/
 else{
 	echo "alreadytagged";
}