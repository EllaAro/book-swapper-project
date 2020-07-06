# Book Swapper Project
## Description
The 'BookSwapper' application was created as my final project in the course 'Data-Centered Crowdsourcing Workshop' taken as part of my Bachelor's Degree in Computer Science in Tel Aviv University.

The application serves as a platform for exchanging books (used books, unread books) between people.

Users get recommended new books based on their "likes" of other books found on the website.

Users begin their journey on the website with 5 "tokens" - with these tokens the user is able to "pay" for books recieved by other users.
This was implemented in order to prevent a bad usage of the website and to solve the 'free rider' problem.

Once a user decides to accept an offered book on the website, he recives a special generated code. The user has to pass this code to the book owner. Once the book owner enters the code in a special region in the website, then he gets one token for giving away the book he has offered. This feature was inspired by the `TCP 3-Way Handshake`.

The main algorithm the application is based on is the `Collaborative Filtering` Algorithm.
Collaborative filtering (CF) is a technique used by recommender systems. Collaborative filtering has two senses, a narrow one and a more general one.
In the newer, narrower sense, collaborative filtering is a method of making automatic predictions (filtering) about the interests of a user by collecting preferences or taste information from many users (collaborating). The underlying assumption of the collaborative filtering approach is that if a person A has the same opinion as a person B on an issue, A is more likely to have B's opinion on a different issue than that of a randomly chosen person. 

## Implementation
* The application was written in `PHP` as the back-end server. 
* The database used is a relational `MySQL` database.
* Pure `Vanilla Javascript` ,`JQuery` and `CSS` were used as the front-end client.
* Usage of `Google Books API` for retrieving and adding books which do not exist in the DB. 
