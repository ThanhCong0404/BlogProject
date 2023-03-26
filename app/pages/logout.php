<?php 

	//remove session user login and redirect to home page
	if(!empty($_SESSION['USER']))
		unset($_SESSION['USER']);

	redirect("home");
?>