<?php
session_start();
/*Connecting to the database*/
require 'dbh_inc.php';
$name= $_POST['name'];
$name= str_replace("'","''", $name);
$link= $_POST['link'];
$authors= $_POST['authors'];
$authors= str_replace("'","''",$authors);
$isbn= $_POST['isbn'];
$summary= $_POST['summary'];
$summary = str_replace("'","''", $summary);
/*Making sure that the user doesn't add the same book*/
$query= "SELECT * FROM books WHERE name='$name' ";
$results = mysqli_query($conn, $query);
if(!($row=mysqli_fetch_assoc($results))){
	$query = "INSERT INTO books (name, link, authors, isbn, summary) 
  	VALUES('$name', '$link', '$authors', '$isbn', '$summary')";
  	$result = mysqli_query($conn, $query);
	if ( false===$result ) {
  		echo mysqli_error($conn);
	}
	else{
		echo "success";
	}
}
/*The book exists*/
else{
	echo "havealready";
}