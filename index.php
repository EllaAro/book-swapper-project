<?php
	require "header.php";
?>
	<!-- Once we've included the header file we can proceed with the index page (login page) -->
	<main>
		<div class="wrapper-main">
			<section class="section-default">
				<?php
					/*if we get a successful login, a corresponding message will be presented*/
					if(isset($_GET['login'])){ 
						include "core/login_success.php";
					}
					/*Else If, the user has succesfully signed up he will be returned to the index page and this message will be displayed*/
					else if(isset($_GET['index'])){
						echo '<p class="signin-status">Successfully signed up!</p>';
					}
				?>
			</section>
		</div>
	</main>

<?php
	require "footer.php";
?>