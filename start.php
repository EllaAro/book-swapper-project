<?php 
include('includes/books_inc.php');
if(!isset($_SESSION['userUid'])){
	header('location:../bookswapper');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Metadata about the site -->
	<meta charset= "utf-8">
	<meta name= viewport content= "width=device-width, initial-scale=1">
	<title>Bookswapper</title>
	<script src="js/jquery-3.3.1.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Boostrap slider links and scripts includes -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"> </script>
	<link rel="stylesheet" href="css/start.css">
</head>


<body>
	<form method="post">
	  		<!-- This is the first bar/banner of the site where the search-bar and the logout button -->
	  		<div id="first-bar">
				<div class="first-bar-logo">
				<a href="start.php"> <img src="img/banner7.png" alt="logo" id="logo-size" /> </a>
				</div>	
				<div id="search-bar-logout">
					<div class="wrap">
   						 	<div class="search">
      						<input type="text" name="search-word" class="searchTerm-bar" placeholder="What are you looking for?">
      						<button type="submit" name="search-submit" class="searchButton-bar">
        						<i class="fa fa-search"></i>
								<li> <input type="hidden" name="curruser" value="<?php echo $_SESSION['userUid']; ?>"/> </li>
     						</button>								
   							</div>
					</div>
					<a id="notify" href="notify.php"><i class="fa fa-bell"></i></a>
					<a id="logout" href="includes/logout_inc.php? logout= '1'">Logout</a>
				</div>
			</div>
			<!-- This is the second bar/banner of the site where all of the options lay -->
	  		<div id= "second-bar" class="stickybar">
		  		<ul>
		  			<li>
		  				<div class="dropdown-bar">
				          <button class="dropbtn-bar">My Books</button>
				          <div class="dropdown-content-bar">
				           <input type="submit" name="action" value="Books I Like"/>
				            <input type="submit" name="action" value="Books I Am Giving Away"/>
							<input type="submit" name="action" value="Books I Want"/>
							<input type="submit" name="action" value="Books I Want - Available Only"/>
				          </div>  
		  			</li>

					<li>
		  				<div class="dropdown-bar">
				          <button class="dropbtn-bar">All Of The Books</button>
				          <div class="dropdown-content-bar">
				          	<div class="all-of-the-books">
				           <input type="submit" name="action" value="All Books"/>
				           <input type="submit" name="action" value="Fiction"/>
				           <input type="submit" name="action" value="Novel"/>
				           <input type="submit" name="action" value="Travel"/>
				           <input type="submit" name="action" value="Mystery"/>
				           <input type="submit" name="action" value="Romance"/>
				           <input type="submit" name="action" value="Thriller"/>
				           <input type="submit" name="action" value="Horror"/>
				           <input type="submit" name="action" value="Crime"/>
				           <input type="submit" name="action" value="Textbook"/>
				           <input type="submit" name="action" value="Political"/>
				           <input type="submit" name="action" value="Comedy"/>
				           <input type="submit" name="action" value="Drama"/>
				           <input type="submit" name="action" value="Action"/>
				           <input type="submit" name="action" value="Children"/>
				           <input type="submit" name="action" value="Religion"/>
				           <input type="submit" name="action" value="Science"/>
				           <input type="submit" name="action" value="History"/>
				           <input type="submit" name="action" value="Anthology"/>
				           <input type="submit" name="action" value="Poetry"/>
				           <input type="submit" name="action" value="Dictionaries"/>
				           <input type="submit" name="action" value="Comics"/>
				           <input type="submit" name="action" value="Art"/>
				           <input type="submit" name="action" value="Cookbooks"/>
				           <input type="submit" name="action" value="Diaries"/>
				           <input type="submit" name="action" value="Trilogy"/>
				           <input type="submit" name="action" value="Autobiographies"/>
				           <input type="submit" name="action" value="Fantasy"/>
				        </div>  
				    </div>
		  			</li>


		  			<li> <input type="submit" name="action" value="Available Books"/> </li>

		  			<li>
		  				<div class="dropdown-bar">
				          <button class="dropbtn-bar">Matching Books</button>
				          <div class="dropdown-content-bar">
				           		<input type="submit" name="action" value="Order By Match"/>
								<input type="submit" name="action" value="Available Matching Books"/>
				        </div>  
		  			</li>
					<li> <input type="submit" name="action" value="Most Popular"/> </li>		
					<li> <input type="submit" name="action" value="Most Wanted Books"/> </li>
					<li> <input type="hidden" name="curruser" value="<?php echo $_SESSION['userUid']; ?>"/> </li>
				</ul>
			</div>
	</form>
			<?php
			//We haven't chosen anything yet - front page
			if(!isset($_POST['action']) && !isset($_POST['search-submit'])){
				include "firstpage.php";
			}
			?>
		<form method="post">
			<?php
			if(isset($_POST['action']) || isset($_POST['search-submit'])){
			echo '<div class="bookcont">';
			$i = 0;
			$j = 0;
			$flag = false;
			// Search has returned nothing, we want to create a box which allows users to add their books.
			if($emptySearch===1){
				echo
					'<center>
						<div class="bookAdder">
							<p>Cannot find your book? Fill in the information and we will add the book for you! </p>
							<input id="search" class="searchTerm-bar searchTerm-book" placeholder="Type in the ISBN">
							<br>
							<br>
							<input id="searchname" class="searchTerm-bar searchTerm-book" placeholder="Type in the book name">
						
							<button id="button" type="button">Click me</button>
							<br>
							<br>
							<div id="results"></div>
						</div>
						<br>
						<br>
						<br>
						<br>
					</center>
					<script src="js/searchJs.js"> </script>';
			}
			// else...
			else{
			  	foreach ($books as $book) : 
					$imgurl=$urls[$j];
					$flag = false;
					echo '<div class="bookdiv">';
					echo '<br>';
					echo '<div class="book-container">';	
					echo '<img src="';
					echo $imgurl;
					echo '" alt="Avatar" class="urlimg"> ';
					
					if(in_array($book,$stock)){
					 echo '<div class="middle">
					    <div class="text avail">Available</div>
					  </div> </div>';
					}
					else{
					 echo '<div class="middle">
					    <div class="text unavail">Unavailable</div>
					  </div> </div>';
					  $flag = true;  
					}
					echo '<br>';
					echo '<p class="book">' .$book;
					echo '</p>';
					$author = $authors[$j];
					echo '<center <p class="book authors">' .$author;
					echo '</p> </center>' ;
					echo ' <center>
					
					<span>';
					$j++;
					if(in_array($book,$likes)){
						echo "<a href=includes/books_inc.php?unlikedName=",urlencode($book),"&username=",urlencode($_SESSION['userUid']),"> unLike |</a>"; 
					}
					else{
						echo "<a href=includes/books_inc.php?likedName=",urlencode($book),"&username=",urlencode($_SESSION['userUid']),"> Like |</a>";
					}
					if(in_array($book,$givesaway)){
						echo " <a href=includes/books_inc.php?dontgiveName=",urlencode($book),"&username=",urlencode($_SESSION['userUid']),"> Don't give away |</a>"; 
					}
					else{
						echo "<a href=includes/books_inc.php?giveName=",urlencode($book),"&username=",urlencode($_SESSION['userUid']),"> Give Away |</a>"; 
					}
					echo "<a href=includes/books_inc.php?details=",urlencode($book),"&username=",urlencode($_SESSION['userUid']),"> Details</a>";
					if(in_array($book, $userWants)){
						echo "<br><a href=includes/books_inc.php?dontwantBook=",urlencode($book),"&username=",urlencode($_SESSION['userUid']),">Don't Want It </a>";
					}
					else{
						echo "<br><a href=includes/books_inc.php?wantBook=",urlencode($book),"&username=",urlencode($_SESSION['userUid']),"> Want It </a>";	
						}
						if(!in_array($book, $userTagged)){
						$userTag= $_SESSION["userUid"];
						echo "<a class='trigger_popup_fricc'> | Tag It </a>";	
						echo 	"<div class='hover_bkgr_fricc'>
									    <span class='helper'></span>
									    <div class='TagItDiv'>
										        <div class='popupCloseButton'>X</div>
										        <p style='font-weight:bold'>";									
												echo $book;
												echo '</p>
												<p class="opt1">Enter the main genre:</p>
												<input list="genres" name="mainGen" class="firstOption">
												<p class="opt2">Enter book secondery genre (optional):</p>
												<input list="genres" name="secGen" class="secondOption">
												<input type="hidden" class="curruser" value="'.$userTag.'">
												<input type="hidden" class="currbook" value="'.$book.'">
												<span class="tagMsg"></span>
												<button type="button" class="genreButton">Add</button>
												<datalist id="genres">
													<option value="Fiction">
													<option value="Novel">
													<option value="Travel">
													<option value="Mystery">
													<option value="Romance">
													<option value="Thriller">
													<option value="Horror">
													<option value="Crime">
													<option value="Textbook">
													<option value="Political">
													<option value="Comedy">
													<option value="Drama">
													<option value="Action">
													<option value="Children">
													<option value="Religion">
													<option value="Science">
													<option value="History">
													<option value="Anthology">
													<option value="Poetry">
													<option value="Dictionaries">
													<option value="Comics">
													<option value="Art">
													<option value="Cookbooks">
													<option value="Diaries">
													<option value="Trilogy">
													<option value="Autobiographies">
													<option value="Fantasy">
												</datalist>
												
									    </div>
								  </div>';
					
					echo '</span> </center>';
						}
					echo '</div>';	
			  	 endforeach 
		  	 ?>
		  	 <?php
		  	}
		  	echo '</div>';
		  	}
		  	?>
	</form>
	<script src="js/rankit.js"> </script>
</body>
</html>