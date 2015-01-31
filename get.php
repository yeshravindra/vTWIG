<?php
	//include "db.php";
	$id = addslashes($_REQUEST['id']);
	$image=mysql_quesry("SELECT * FROM store WHERE id=$id");
	$image =mysql_fetch_assoc($image);
	$image=$image['image'];
	header("Content-type: image/jpeg");
	echo $image;
?>