<?php
	include 'core/init.php';
	protect_page();
	
	if (album_check($_GET['album_id'])===false) {
		header('Location:albums.php');
		exit();}
		
	if (isset($_GET['album_id'])) {
		$album_id=$_GET['album_id'];
		delete_album($album_id);
		header('Location:albums.php');
		exit();
	}
	
	
?>