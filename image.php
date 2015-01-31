<html>
<head>
	<title>Image</title>
</head>
<body>
	<form action="image.php" method="POST" enctype="multipart/form-data">
	File:
	<input type="file" name="image"> <input type="submit" value="Upload"> </form>
<?php
	//include "db.php";
	$file =$_FILES['image']['tmp_name'];
	
	if (!isset($file))
		echo "Please select an image";
	else
	{
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$image_name= addslashes($_FILES['image']['name']);
		$image_size =getimagesize($_FILES['image']['tmp_name']);
	}
	if ($image_size===FALSE){
		echo "That's not an image";}
	else
	{		$insert = "INSERT into table2 (picture) values ('".$image."')";
			$inserted = mysql_query($insert);
		if (!$inserted){
			echo "Problem uploading image!";
			}
//$register="INSERT into table2 (username,password,first_name,second_name,email)values('".$username."','".$password."','".$first."','".$last."','".$mail."')";
//$registered=mysql_query($register);
			
		else
		{
			$lastid = mysql_insert_id();
			echo "Image uploaded<p/> Your image:<p/><img src=get.php?id=1";
		}
	
	}
?>
</body>

</html>