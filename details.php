<?php 
if(!isset($_SESSION['userUid'])){
	header('location:../');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Bookswapper</title>
	<link rel="stylesheet" href="../css/start.css">
	<link rel="stylesheet" href="../css/details.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>
	<!-- First bar of the page where is the logout,back and logo -->
	<div id="first-bar">
		<div class="first-bar-logo">
		<a href="../start.php"> <img src="../img/banner7.png" alt="logo" id="logo-size" /> </a>
		</div>	
		<div id="search-bar-logout">
			<a id="logout" href="logout_inc.php? logout= '1'">Logout</a>
			<a id="backbtn" href="../start.php">Back</a>
		</div>
	</div>	
	<!-- This is the second bar which contains the status of the tokens -->
	<div id= "second-bar" class="stickybar">
	  	<ul>
			<li> <p class="token-notify"> Hey <?php echo $username;?> ,you've got
			<?php
			if($tokUser<1){
				echo "0 tokens. Give away old books to earn tokens.";
			}
			else if($tokUser==1){
				echo $tokUser;
				echo ' token.';
			}
			else{
				echo $tokUser;
				echo ' tokens.';
			}
			?>
			</p></li>
		</ul>
	</div>
	<!-- Information about the book -->
	<div class="bookcont">
		<div id="wrapper">
		<?php
			echo '<br>';
			echo '<br>';
			echo '<div class="img"> <img src="';
			echo $link;
			echo '" alt="Avatar" class="detail-img">';
			?>
		</div>

		<div class="info-about">
		<h2><?php
			echo $bookName; ?></h2>
		<p> by  <span style="font-weight:bold"> <?php echo $authors; ?> </span> </p>
		<?php
		echo '<div class="info-box">';
		echo "<span class='text-header'>Description </span> <br>" .$summary;
		echo '<div id="bookDesc"></div>';
		echo "<br><span class='text-header'> ISBN </span> <br> ".$isbn ;
		if(!empty($genresCrowd)){
			$flag = true;
			echo "<br><br> <span class='text-header'>Most Tagged As </span> <br> ";	
			foreach ($genresCrowd as $gen) :
				if($flag){
					echo $gen;
					$flag = false;
				}
				else{
					echo ", ".$gen;
				}
			endforeach;
		}
		if($rank>0){
		echo "<br><br><span class='text-header'> Number Of Likes</span> <br> ".$rank ;
	}
		echo "</div>";

		?>
		</div>
		</div>
		<!-- Checking if the book is available -->
		<?php
		if(empty($usersOffer)){
			echo "<center> <h2> The Book Is Not Available Right Now</h2> </center>";
		}

		// Information about users who are willing to swap the book
		else{ 
			//lets see that the users offering the book isn't the user itself
			$theUserExists=0;
			foreach ($usersOffer as $user) :
				if($user['user']==$username){
					$theUserExists=1;
				}
			endforeach;
			if($theUserExists==0){
			echo "<center> <h2>The Book Is Offered By These Users</h2> </<center>";
			echo '<table>
  					<tr>
    					<th>User</th>
    					<th>Location</th>
    					<th>Email</th>
    					<th>Token </th>
  					</tr>';

			foreach ($usersOffer as $user) : 
			if($username!==$user['user']){
				echo "<tr> <td class='UserGiver'>".$user['user']."</td> <td>".$user['locUsers']."</td><td>".$user['emailUsers']."</td>"; 
				if($tokUser>0){
					echo "<td>
							<br>
							<input type='button' class='TokenBtn' value='Give Token'/>
							<span class='TokenCode'> </span>
							<br>
							<br>
							<input type='button' class='CancelTokenBtn' value='Cancel Given Token'  style='display:none'/>

						 </td>";
				}
				else{
					echo "<td><span class='no-tokens'>No Tokens</span> </td>";
				}
				echo "</tr>";
			}
			endforeach;
			echo "</table>";
		}
	}
		?>
	</div>
	<br>
	<br>
	<script>
	$(document).ready(function(){
		$(".TokenBtn").click(function(){
			var tok = generateToken();
			var td = $(this).parent();
			var tokenThis = td.find(".TokenCode");
			var CancelBtn = td.find(".CancelTokenBtn")
			td.find(".tokenInput").val(tok);
			var fromUser= "<?php echo ($_SESSION['userUid']);?>";
			var book= "<?php echo $bookName;?>";
			// getting the user we want to send him the token
			var tr=td.parent();
			var toUser_element= tr.children('.UserGiver');
			var toUser= toUser_element.text();
			// passing the informatoin to the backend so we could back it up in an sql dataset
			$.post("token_inc.php", {tokenCode: tok, fromUser:fromUser, toUser:toUser, book:book },  
			function(data){
				if (data=="none"){
					tokenThis.html("The code is: "+tok);
				 	CancelBtn.css({"display":"block"});

				}
				else{
					tokenThis.html(" You've already received this code: "+data);
					CancelBtn.css({"display":"block"});
				}
			});

		});

		$(".CancelTokenBtn").click(function(){
			var td = $(this).parent();
			var CancelBtn = td.find(".CancelTokenBtn")
			var fromUser= "<?php echo ($_SESSION['userUid']);?>";
			var book= "<?php echo $bookName;?>";
			var tokenThis = td.find(".TokenCode");
			// getting the user we want to send him the token
			var tr=td.parent();
			var toUser_element= tr.children('.UserGiver');
			var toUser= toUser_element.text();
			// passing the informatoin to the backend so we could back it up in an sql dataset
			$.post("token_inc_delete.php", {fromUser:fromUser, toUser:toUser, book:book },  
			function(){
					tokenThis.html("");
				 	CancelBtn.css({"display":"none"});

			});

		});
		function generateToken(){
			  var text = "";
  			  var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
			  for (var i = 0; i < 7; i++)
   			  text += possible.charAt(Math.floor(Math.random() * possible.length));
   			return text;
		}
});
    </script>
</body>

</html>