		function bookSearch(){
			var search = document.getElementById('search').value;
			var searchbook = document.getElementById('searchname').value;
			document.getElementById('results').innerHTML="";

			console.log("the name of the book is: "+searchbook);

			$.ajax({
				url:"https://www.googleapis.com/books/v1/volumes?q=" + search,
				dataType:"json",

				success: function(data){
						ins_searchBook = searchbook.toUpperCase();
						ins_realBook = data.items[0].volumeInfo.title.toUpperCase();
						if(!(ins_searchBook.includes(ins_realBook) || ins_realBook.includes(ins_searchBook))
							|| isNaN(search)){
							console.log(isNaN(search));
							document.getElementById('results').innerHTML="Error, Invalid information was given.";
						}
						else{
							var title = data.items[0].volumeInfo.title;
							var authors = data.items[0].volumeInfo.authors[0];
							var img = data.items[0].volumeInfo.imageLinks.thumbnail;
							var description = data.items[0].volumeInfo.description;
							$.post("includes/addbook_inc.php", {name: title, link: img, authors: authors, isbn: search, summary: description},  
								function(data){
									if(data=="havealready"){
										document.getElementById('results').innerHTML="The book already exists!";
									}
									else if(data=="success"){
										document.getElementById('results').innerHTML="Added sucessfully";
									}
									
									document.getElementById('search').value="";
									document.getElementById('searchname').value="";
							});
						}
				},

				type: 'GET'
			});
				
		}
		document.getElementById('button').addEventListener('click',bookSearch,false);