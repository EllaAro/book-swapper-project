<?php
session_start();
/*Connecting to the database*/
require 'dbh_inc.php';
$fromUser= $_POST['fromUser'];
$toUser= $_POST['toUser'];
$book= $_POST['book'];
$book = str_replace("'","''", $book);

$query= "DELETE FROM tokenstatus WHERE fromUser='$fromUser' AND toUser='$toUser' AND book='$book' ";
mysqli_query($conn, $query);