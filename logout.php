<?php

	session_start();
	session_destroy();
	//session_unset();
	echo"You were logged out successfully!";
	header ('Location: index.php');
?>