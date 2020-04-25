<?php
session_start();
/*Initalizing the variables*/
$results="";
$username = "";
$books = array(); 
$authors = array();
$likes = array();
$givesaway = array();
$ranks = array();
$urls = array();
$stock = array();
$userWants = array();
$userTagged = array();
$emptySearch=0;

/*Connecting to the database*/
require 'dbh_inc.php';

//when the user click the search action button, the script pass the results as arrays
if(isset($_POST['search-submit'])){
	$username = $_POST['curruser'];
	$search= mysqli_real_escape_string($conn,$_POST['search-word']);
	$query="SELECT * FROM books WHERE name LIKE '%$search%' OR authors LIKE '%$search%' OR isbn LIKE '%$search%'";
	$results = mysqli_query($conn,$query);
	$row = mysqli_fetch_assoc($results);
	if(is_null($row)){
		$emptySearch=1;
	}
	else{
		do{
			array_push($books, $row['name']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
		}while($row = mysqli_fetch_assoc($results));
	}
	//maintain arrays in order to display the books "correctly" to the user
	$query="SELECT * FROM likes WHERE likes.user = '$username'";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($likes, $row['book']);
	}
	$query="SELECT * FROM givesaway WHERE givesaway.user = '$username'";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($givesaway, $row['book']);
	}
	$query="SELECT * FROM wanted WHERE wanted.user = '$username'";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($userWants, $row['book']);
	}
	$query="SELECT DISTINCT book FROM givesaway";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($stock, $row['book']);
	}
	$query="SELECT DISTINCT book FROM genres WHERE genres.user = '$username' ";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($userTagged, $row['book']);
	}
}

//when the user click one of the display book options
if (isset($_POST['action'])){
	$username = $_POST['curruser'];
	if ($_POST['action'] == 'All Books'){
		$query="SELECT * FROM books";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['name']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
		}
	}
	// show books by their tagged genre
	if ($_POST['action'] == "Fiction" || $_POST['action'] == "Travel" || $_POST['action'] == "Novel" || $_POST['action'] == "Mystery" || $_POST['action'] == "Romance" || $_POST['action'] == "Thriller" || $_POST['action'] == "Horror" || $_POST['action'] == "Crime" || $_POST['action'] == "Textbook" || $_POST['action'] == "Political" || $_POST['action'] == "Comedy" || $_POST['action'] == "Drama" || $_POST['action'] == "Action"|| $_POST['action'] =="Children" || $_POST['action'] == "Religion" || $_POST['action'] == "Science" || $_POST['action'] == "History" || $_POST['action'] =="Anthology"  || $_POST['action'] =="Poetry"  || $_POST['action'] == "Dictionaries" || $_POST['action'] =="Anthology" || $_POST['action'] =="Comics" || $_POST['action'] == "Art" || $_POST['action'] == "Cookbooks" || $_POST['action'] =="Diaries" || $_POST['action']=="Trilogy" || $_POST['action']== "Autobiographies" || $_POST['action'] =="Fantasy" ){
		$genre=$_POST['action'];
		$query="SELECT * from books INNER JOIN genres ON genres.book = books.name and genres.genre='$genre' GROUP by genres.book ORDER BY COUNT(genres.genre) DESC; ";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['name']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
		}
	}
	if ($_POST['action'] == 'Most Popular'){
		$query="SELECT book, COUNT(likes.book) AS `value_occurrence`, link, authors
		FROM likes JOIN books ON likes.book = books.name
		GROUP BY likes.book
		ORDER BY `value_occurrence` DESC";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
			array_push($ranks, $row['value_occurrence']);
		}
	}
	if ($_POST['action'] == 'Available Books'){
		$query="SELECT distinct book, link, authors FROM givesaway JOIN books ON givesaway.book = books.name";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
		}
	}
	if ($_POST['action'] == 'Most Wanted Books'){
		$query="SELECT book,authors, COUNT(wanted.book) AS `value_occurrence`, link
		FROM wanted JOIN books ON wanted.book = books.name
		GROUP BY wanted.book
		ORDER BY `value_occurrence` DESC";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
		}
	}
	if ($_POST['action'] == 'Books I Am Giving Away'){
		$query="SELECT book,link, authors
		FROM givesaway JOIN books ON givesaway.book = books.name AND givesaway.user = '$username'";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
		}
	}
	if ($_POST['action'] == 'Books I Want'){
		$query="SELECT book,link, authors
		FROM wanted JOIN books ON wanted.book = books.name AND wanted.user = '$username'";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($urls, $row['link']);
			array_push($authors, $row['authors']);
		}
	}
	if ($_POST['action'] == 'Books I Want - Available Only'){
		$query="SELECT wanted.book,link,authors
		FROM wanted
		JOIN givesaway ON wanted.book = givesaway.book
		JOIN books ON wanted.book = books.name AND wanted.user = '$username'";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($urls, $row['link']);
			array_push($authors, $row['authors']);
		}
	}
	if ($_POST['action'] == 'Books I Like'){
		$query="SELECT book,link, authors
		FROM likes JOIN books ON likes.book = books.name AND likes.user = '$username'";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
		}
	}
	//combination between collaborative filtering ang genre preferences
	//may take several seconds - can be solved using background computations 
	if ($_POST['action'] == 'Order By Match'){
		//user similarity table - calculate number of books that the current user and other users both like
		$query="CREATE TEMPORARY TABLE similarityTable as
			select similar.user,count(*) rank
			from likes target
			join likes similar on target.book = similar.book
			and target.user != similar.user
			where target.user = '$username'
			group by similar.user";
		mysqli_query($conn,$query);
		//collaborative filtering
		$query = "CREATE TEMPORARY TABLE res as 
			select similar.book, sum(similarityTable.rank) total_rank
			from similarityTable
			join likes similar on similarityTable.user = similar.user
			left join likes target on target.user = '$username' and target.book = similar.book
			where target.book is null
			group by similar.book 
			order by total_rank desc";
		$collBooks = array();
		mysqli_query($conn,$query);
		$query = "select book,total_rank from res";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($collBooks, $row['book']);
		}
		//adding genre preferences to the collaborative algorithm:
		//a table containing 3 main genres for each book
		$query = "CREATE TEMPORARY TABLE bookGenresTable AS select * from genres limit 0";
		mysqli_query($conn,$query);
		$query = "SELECT name FROM books";
		$results = mysqli_query($conn,$query);
		$allBooks = array();
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($allBooks, $row['name']);
		}
		foreach($allBooks as $book):
			$book = str_replace("'","''",$book);
			$query = "SELECT genre, COUNT('genre') as countGen
					FROM genres		
					WHERE book='$book'
					GROUP BY `genre`
					ORDER BY `countGen` DESC
					LIMIT 3";
			$results = mysqli_query($conn,$query);
			while ($row = mysqli_fetch_assoc($results)) {
				$gen = $row['genre'];
				$query = "INSERT INTO bookGenresTable (book,genre) 
					VALUES('$book','$gen')";
				mysqli_query($conn,$query);
			}
		endforeach;
		//find user's 3 favourite genres using bookGenresTable and likes
		$query="SELECT genre, COUNT('genre') as countGen
			FROM bookGenresTable JOIN likes		
			WHERE likes.user = '$username' and likes.book = bookGenresTable.book
			GROUP BY `genre`
			ORDER BY `countGen` DESC
			LIMIT 3";
		$results = mysqli_query($conn,$query);
		//for each book that match one (or more) of the 3 favourite genre, increase book rank
		//multiplicate by 1.5 for each match - a parameter that may be changed as the datasets get bigger
		while ($row = mysqli_fetch_assoc($results)) {
			$gen = $row['genre'];
			$query = "UPDATE res JOIN bookGenresTable
				on res.book = bookGenresTable.book 
				SET total_rank = total_rank*1.5
				WHERE genre='$gen'";
			mysqli_query($conn,$query);
		}
		$query="SELECT res.book, res.total_rank, link, authors FROM res JOIN books ON res.book = books.name ORDER BY `total_rank` DESC";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
			array_push($ranks, $row['total_rank']);
		}
	}
	//same as before + display only available books + collaborative filtering for wanted books
	if ($_POST['action'] == 'Available Matching Books'){
				//user similarity table - calculate number of books that the current user and other users both like
		$query="CREATE TEMPORARY TABLE similarityTable as
			select similar.user,count(*) rank
			from likes target
			join likes similar on target.book = similar.book
			and target.user != similar.user
			where target.user = '$username'
			group by similar.user";
		mysqli_query($conn,$query);
		//collaborative filtering
		$query = "CREATE TEMPORARY TABLE res as 
			select similar.book, sum(similarityTable.rank) total_rank
			from similarityTable
			join likes similar on similarityTable.user = similar.user
			left join likes target on target.user = '$username' and target.book = similar.book
			where target.book is null
			group by similar.book 
			order by total_rank desc";
		$collBooks = array();
		mysqli_query($conn,$query);
		$query = "select book,total_rank from res";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($collBooks, $row['book']);
		}
		//adding genre preferences to the collaborative algorithm:
		//a table containing 3 main genres for each book
		$query = "CREATE TEMPORARY TABLE bookGenresTable AS select * from genres limit 0";
		mysqli_query($conn,$query);
		$query = "SELECT name FROM books";
		$results = mysqli_query($conn,$query);
		$allBooks = array();
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($allBooks, $row['name']);
		}
		foreach($allBooks as $book):
			$book = str_replace("'","''",$book);
			$query = "SELECT genre, COUNT('genre') as countGen
					FROM genres		
					WHERE book='$book'
					GROUP BY `genre`
					ORDER BY `countGen` DESC
					LIMIT 3";
			$results = mysqli_query($conn,$query);
			while ($row = mysqli_fetch_assoc($results)) {
				$gen = $row['genre'];
				$query = "INSERT INTO bookGenresTable (book,genre) 
					VALUES('$book','$gen')";
				mysqli_query($conn,$query);
			}
		endforeach;
		//find user's 3 favourite genres using bookGenresTable and likes
		$query="SELECT genre, COUNT('genre') as countGen
			FROM bookGenresTable JOIN likes		
			WHERE likes.user = '$username' and likes.book = bookGenresTable.book
			GROUP BY `genre`
			ORDER BY `countGen` DESC
			LIMIT 3";
		$results = mysqli_query($conn,$query);
		//for each book that match one (or more) of the 3 favourite genre, increase book rank
		//multiplicate by 1.5 for each match - a parameter that may be changed as the datasets get bigger
		while ($row = mysqli_fetch_assoc($results)) {
			$gen = $row['genre'];
			$query = "UPDATE res JOIN bookGenresTable
				on res.book = bookGenresTable.book 
				SET total_rank = total_rank*1.5
				WHERE genre='$gen'";
			mysqli_query($conn,$query);
		}
		$query="SELECT res.book, res.total_rank, link, authors FROM res
				JOIN books ON res.book = books.name
				JOIN givesaway on res.book = givesaway.book
				ORDER BY `total_rank` DESC";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
			array_push($ranks, $row['total_rank']);
		}
		//collaborative for wanted books - find available only:
		//user similarity table - calculate number of books that the current user and other users both like
		$query="CREATE TEMPORARY TABLE similarityTablee as
			select similar.user,count(*) rank
			from wanted target
			join wanted similar on target.book = similar.book
			and target.user != similar.user
			where target.user = '$username'
			group by similar.user";
		mysqli_query($conn,$query);
		//collaborative filtering
		$query = "CREATE TEMPORARY TABLE ress as 
			select similar.book, sum(similarityTablee.rank) total_rank
			from similarityTablee
			join wanted similar on similarityTablee.user = similar.user
			left join wanted target on target.user = '$username' and target.book = similar.book
			where target.book is null
			group by similar.book 
			order by total_rank desc";
		mysqli_query($conn,$query);
		$query="SELECT ress.book, link,authors FROM ress
		JOIN books ON ress.book = books.name
		JOIN givesaway on ress.book = givesaway.book
		left join res on ress.book = res.book WHERE ress.book is null";
		$results = mysqli_query($conn,$query);
		while ($row = mysqli_fetch_assoc($results)) {
			array_push($books, $row['book']);
			array_push($authors, $row['authors']);
			array_push($urls, $row['link']);
		}
	}
	//maintain arrays in order to display the books "correctly" to the user
	$query="SELECT * FROM likes WHERE likes.user = '$username'";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($likes, $row['book']);
	}
	$query="SELECT * FROM givesaway WHERE givesaway.user = '$username'";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($givesaway, $row['book']);
	}
	$query="SELECT * FROM wanted WHERE wanted.user = '$username'";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($userWants, $row['book']);
	}
	$query="SELECT DISTINCT book FROM givesaway";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($stock, $row['book']);
	}
	$query="SELECT DISTINCT book FROM genres WHERE genres.user = '$username' ";
	$results = mysqli_query($conn,$query);
	while ($row = mysqli_fetch_assoc($results)) {
		array_push($userTagged, $row['book']);
	}
}

// a book marked "like"
if (isset($_GET['likedName'])){
	$bookName =str_replace("'","''",$_GET['likedName']);
	$username = $_GET['username'];
	$query = "INSERT INTO likes (user, book) 
		VALUES('$username', '$bookName')";
	mysqli_query($conn, $query);
	header("location: ../start.php");
}
// a book marked "unlike"
if (isset($_GET['unlikedName'])){
	$bookName =str_replace("'","''",$_GET['unlikedName']);
	$username = $_GET['username'];
	$query = "DELETE FROM likes 
		WHERE user = '$username' AND book = '$bookName'";
	mysqli_query($conn, $query);
	header("location: ../start.php");
}

// a book marked "give away"
if (isset($_GET['giveName'])){
	$bookName =str_replace("'","''",$_GET['giveName']);
	$username = $_GET['username'];
	$query = "INSERT INTO givesaway (user, book) 
		VALUES('$username', '$bookName')";
	mysqli_query($conn, $query);
	header("location: ../start.php");
}

// a book marked "tag it"
if (isset($_GET['tagBook'])){
	$bookName = $_GET['tagBook'];
	$username = $_GET['username'];
	require '../chooseGen.php';
}

// a book marked "don't give away"
if (isset($_GET['dontgiveName'])){
	$bookName =str_replace("'","''",$_GET['dontgiveName']);
	$username = $_GET['username'];
	$query = "DELETE FROM givesaway
		WHERE user = '$username' AND book = '$bookName'";
	mysqli_query($conn, $query);
	header("location: ../start.php");
}

// a book marked "want it"
if (isset($_GET['wantBook'])){
	$bookName =str_replace("'","''",$_GET['wantBook']);
	$username = $_GET['username'];
	$query = "INSERT INTO wanted (user, book) 
		VALUES('$username', '$bookName')";
	mysqli_query($conn, $query);
	header("location: ../start.php");
}

// a book marked "don't want it"
if (isset($_GET['dontwantBook'])){
	$bookName =str_replace("'","''",$_GET['dontwantBook']);
	$username = $_GET['username'];
	$query = "DELETE FROM wanted
		WHERE user = '$username' AND book = '$bookName'";
	mysqli_query($conn, $query);
	header("location: ../start.php");
}

// show details and list of users offerd speciefic book
if (isset($_GET['details'])){
	$bookName = str_replace("'","''",$_GET['details']);
	$username = $_GET['username'];
	//user tokens
	$query="SELECT tokUsers
		FROM users
		WHERE uidUsers = '$username'";
	$results = mysqli_query($conn,$query);
	$row = mysqli_fetch_assoc($results);
	$tokUser = $row['tokUsers'];
	//find genre from dataset
	$query="SELECT link, authors, isbn, summary
		FROM books
		WHERE name = '$bookName'";
	$results = mysqli_query($conn,$query);
	$row = mysqli_fetch_assoc($results);
	// $genre = $row['genre'];
	$link = $row['link'];
	$authors=$row['authors'];
	$isbn=$row['isbn'];
	$summary= $row['summary'];
	//find most tagged genres from crowd tags
	$query="SELECT genre, COUNT('genre') as countGen
		FROM genres		
		WHERE book = '$bookName'
		GROUP BY `genre`
		ORDER BY `countGen` DESC
		LIMIT 3";
	$results = mysqli_query($conn, $query);
	$genresCrowd = array();
	while ($row = mysqli_fetch_assoc($results)){
		array_push($genresCrowd,$row['genre']);
	}
	//calculate rank
	$query="SELECT COUNT('book') AS 'value_occurrence'
		FROM likes
		WHERE book = '$bookName'";
	$results = mysqli_query($conn,$query);
	$row = mysqli_fetch_assoc($results);
	$rank = $row['value_occurrence'];
	//find users offers the book
	$usersOffer = array();
	$query = "SELECT givesaway.user,users.emailUsers,users.locUsers FROM givesaway
			INNER JOIN users ON users.uidUsers=givesaway.user 
			WHERE givesaway.book ='$bookName'";
	$results = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($results)){
		array_push($usersOffer,$row);
	}
	$bookName = str_replace("''","'",$_GET['details']);
	require '../details.php';
}

//give coin from one user to another
if (isset($_GET['fromUser'])){
	$fromUser = $_GET['fromUser'];
	$toUser = $_GET['toUser'];
	$query = "UPDATE users
		SET tokUsers = tokUsers-1
		where uidUsers = '$fromUser'";
	mysqli_query($conn,$query);
	$query = "UPDATE users
		SET tokUsers = tokUsers+1
		where uidUsers = '$toUser'";
	mysqli_query($conn,$query);
	header("location:../start.php");
}

