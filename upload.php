<?php
include ('core/init.php');
protect_page();
include ('user_profiles/thumb_2.php');
$tmp_name = $_FILES['file']['tmp_name'];
include "widgets/header.php";
if (isset($tmp_name)) {
	if (!empty($tmp_name)) {
		
		$location = "user_profiles/".$user_data['username']."/";
					
	if (move_uploaded_file($tmp_name, $location.'profilepic.jpg'))
		$image="profilepic.jpg";
		$destination=$location."/thumb/";
		create_thumb_2($location, $image, $destination);
		echo "Uploaded!!!";
		echo "<br /><a href='home.php'>Back to home page</a>";
		die();
	}
	else{
		echo 'please choose a file';
	}
}
	echo "<br /><a href='home.php'>Cancel and return</a>";
?>
<div id="hfdgft1g">
<form action="upload.php" method="POST" enctype="multipart/form-data">

	<input type="file" name="file"><br><br>
	<input type="submit" value="Upload Picture">

</form></div>
