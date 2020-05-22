# Book Swapper Project
## Description
The 'BookSwapper' application was created as my final project in the course 'Data-Centered Crowdsourcing Workshop' taken as part of my Bachelor's Degree in Computer Science in Tel Aviv University.

The application serves as a platform for exchanging books (used books, unread books) between people.

Users get recommended new books based on their "likes" of other books found on the website.

Users begin their journey on the website with 5 "tokens" - with these tokens the user is able to recieve books from other users. Each token is being taken away from the user once he decides to take a book offered by one of the other users which are signed to the website.
The use is able to gain a token by offering a book and once another user decides to take that book, then does the user get another token for himself. This was implemented in order to prevent a bad usage of the website and to solve the 'free rider' problem.

Once a user decides to accept an offered book on the website, he recives a special generated code. The user has to pass this code to the book owner. Once the book owner enters the code in a special region in the website, then he gets his token for giving away the book he has offered. This feature was inspired by the `TCP 3-Way Handshake`.

The main algorithm the application is based on is the `Collaborative Filtering` Algorithm.
Collaborative filtering (CF) is a technique used by recommender systems. Collaborative filtering has two senses, a narrow one and a more general one.
In the newer, narrower sense, collaborative filtering is a method of making automatic predictions (filtering) about the interests of a user by collecting preferences or taste information from many users (collaborating). The underlying assumption of the collaborative filtering approach is that if a person A has the same opinion as a person B on an issue, A is more likely to have B's opinion on a different issue than that of a randomly chosen person. 
