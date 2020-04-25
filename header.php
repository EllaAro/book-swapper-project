<!-- This is the header of the idex page (login page) and the header of the signup page-->
<?php
// We're starting a session, that means that the user can now submit his information.
session_start(); 
?>
<!DOCTYPE html>
<html>
<!-- This is 'head' of the page -->
<head>
	<!-- Metadata about the head -->
	<meta charset= "utf-8">
	<meta name= viewport content= "width=device-width, initial-scale=1">
	<title>Bookswapper</title>
	<link rel="stylesheet" href="css/loginReg.css">
	<script src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
	<header>
		<nav class-"nav-header-main"> 
		</nav> 
		<div class="header-login">
			<?php
			// If the user is logged in, we will return him to the frontpage, after the logging in part.
			if(isset($_SESSION['userId'])){
				header('location:start.php');

			}
			//If the user isn't logged in we will present him with login requirements (Username, Password) and an option to sign in.
			else{
				echo '	
						<center>
							<div id="container">
							<form action= "includes/login_inc.php" method="post"> 
									<a class="header-logo" href="index.php">
										<img src="img/banner8.png" width="280" height="90" alt="logo"> 
									</a>
									<center>
										<span class="myHeader">Login</span>
									</center>
									<input type="text" class="textField" id="login_user" name="userUid" placeholder="Username"/>
									<br/>
									<input type="password" class="textField" id="login_password" name="pwdUid"  placeholder="Password"/>  
									<br/>
									<br/>
									<span id="submitButton" class="myButton">Submit</span>
									<button type="submit" name="login-submit" id="loginSubmitBtn" class="submitBtn">Login</button>
									<span id="registerButton" class="myButton">Register</span>
									<br/>
								</form>

							<form action="includes/signup_inc.php" method="post">
									<div id="registerFieldsCont">
										<input type="text" class="textField" id="register_user" name="uid" placeholder="Username"/>
										<br/>
										<input type="text" class="textField" id="register_email" name="mail"  placeholder="Email address"/>  
										<br/>
										<input type="password" class="textField" id="register_password" name="pwd"  placeholder="Password"/>  
										<br/>
										<input type="password" class="textField" id="register_password_repeat" name="pwd-repeat"  placeholder="Repeat Password"/>  
										<br/>
										<input list="genres" class="textField" id="user_location" name="location" placeholder="Location">							
										<datalist id="genres">
											<option value="Jerusalem District">
											<option value="Northern District">
											<option value="Haifa District">
											<option value="Central District">
											<option value="Tel Aviv District">
											<option value="Southern District">
											<option value="Judea and Samaria Area">
										</datalist>
										<br/>
										<br/>
										<span id="signupButton" class="myButton">Sign up</span>
										<button type="submit" name="signup-submit" id="signupSubmitBtn" class="submitBtn">Sign up</button>
									</div>
								</form>
							</div>
						</center>';					
			}
			?>
		</div>
	</header>
<script src="js/loginReg.js"></script>