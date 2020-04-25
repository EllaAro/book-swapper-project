<?php
include('includes/notify_inc.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Bookswapper</title>
	<link rel="stylesheet" href="css/start.css">
	<link rel="stylesheet" href="css/details.css">
	<link rel="stylesheet" href="css/notify.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
	<!-- First bar of the page where is the logout,back and logo -->
	<div id="first-bar">
		<div class="first-bar-logo">
		<a href="start.php"> <img src="img/banner7.png" alt="logo" id="logo-size" /> </a>
		</div>	
		<div id="search-bar-logout">
			<a id="logout" href="includes/logout_inc.php? logout= '1'">Logout</a>
			<a id="backbtn" href="start.php">Back</a>
		</div>
	</div>	
	<!-- This is the second bar which contains the status of the offers -->
	<div id= "second-bar" class="stickybar">
	  	<ul> <li> <p class="token-notify"> Hey <?php echo $currUser;?> ,you've got <?php  
	  	if($offerNum>1){
	  		echo $offerNum;
	  		echo ' offers';
	  	}
	  	else if($offerNum==1) {
	  		echo $offerNum;
	  		echo ' offer';
	  	}
	  	else{
	  		echo ' no offers';
	  	}
	  	?>
	  	and <?php
			if($currTokens<1){
				echo "no tokens. Give away old books to earn tokens.";
			}
			else if($currTokens==1){
				echo $currTokens;
				echo ' token.';
			}
			else{
				echo $currTokens;
				echo ' tokens.';
			}
			?></p> </li> </ul>
	</div>

	<!-- This is the content: a table of information about the token givers-->
	<div class="bookcont">
		<?php
		if($offerNum>0){
			echo  "<table>
		  			 <tr>
		    					<th>User</th>
		    					<th>Book</th>
		    					<th>Token </th>
		  			</tr>";
		  	foreach ($content as $option) :
		  		echo "<tr> 
  						<td class='wantedUser'>".$option['fromUser']."</td> 
  						<td class ='wantedBook'>".$option['book']."</td>
  						<td>
  							<div class='dropdown'>
								<input type='button' class='TokenBtn' value='Pass The Token Code'/>
								<div id='myDropdown' class='dropdown-content'>
									<form class='tokensbm'>
										<center>
										<input type='text' name='submitToken' class='submitToken' placeholder='Enter the code...'/>
										<input type='button' class='SubmitTokenBtn' value='Submit'/>
										<br>
										<span class='TokenSuccErr'></span>
										</center>
									</form>
								</div>
							</div>
  						</td>"; 
  				endforeach;
  			echo "</table>
  			  		<br>
			  		<br>
			  		<br>
			  		<br>";
		}
		?>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".TokenBtn").click(function(){
				var pr = $(this).parent();
				var dropdown =pr.find(".dropdown-content").toggle("show");
			});

			$(".SubmitTokenBtn").click(function(){
				var toUsers = "<?php echo ($_SESSION['userUid']);?>";
				var $tr = $(this).closest("tr");
				var wantedUser = $tr.find(".wantedUser").text();
				var wantedBook = $tr.find(".wantedBook").text();
				var tokenCode = $tr.find(".submitToken").val();
				// what do we do once we submit?
				var submitbtn = $(this).closest(".SubmitTokenBtn");
				var submitbox = $tr.find(".submitToken");
				var spanmsg = $tr.find(".TokenSuccErr");
				//connecting to the backend
				$.post("includes/token_given.php", {toUsers: toUsers, wantedUser: wantedUser,
				 wantedBook:wantedBook, tokenCode:tokenCode},
				  	function(data){
				  		if(data=="success"){
				  			$tr.find(".submitToken").val("");
				  			submitbtn.css({"display":"none"});
				  			submitbox.css({"display":"none"});
				  			spanmsg.html("Successfully accepted");
				  		}
				  		else if(data =="notokens"){
				  			$tr.find(".submitToken").val("");
				  			submitbtn.css({"display":"none"});
				  			submitbox.css({"display":"none"});
				  			spanmsg.html("The user has no tokens left");

				  		}
				  		else{
				  			$tr.find(".submitToken").val("");
				  			spanmsg.html("Wrong code");

				  		}
				  	});
			});
		});
	</script>
</body>

</html>
