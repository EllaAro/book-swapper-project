<!DOCTYPE html>
<html>
<?php
if($_GET['login'] =="success"){
	$user=$_SESSION["userUid"];
	echo '	<center>
					<div id="container">
						<a class="header-logo" href="">
							<img src="img/banner8.png" width="280" height="90" alt="logo"> 
						</a>
						<center>
							<span class="myHeader">Welcome <strong>'; 
						echo  $user; 
						echo '</strong></span>
						</center>
						<br/>
						<br/>
						<form action= "start.php" method="post"> 
							<span class="myButton" id="startButton">  Start  </span>
							<button type="submit" name="start-submit" id="startSubmitBtn" class="submitBtn">Start</button>
						</form>
						<br/>
						<br/>
						<form action= "includes/logout_inc.php" method="post"> 
							<span class="myButton" id="logoutButton">Logout</span>
							<button type="submit" name="logout-submit" id="logoutSubmitBtn" class="submitBtn">Logout</button>
						</form>
						<br/>
					</div>
			</center>';	
}?>

</html>
