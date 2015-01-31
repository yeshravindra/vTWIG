<?php
include "core/init.php";	
protect_page();
include "widgets/header.php";
?>

<h3>Upload an Image!</h3>
<?php

if (isset($_FILES['image'],$_POST['album_id'])){
	$image_name = $_FILES['image']['name'];
	$image_size = $_FILES['image']['size'];
	$image_temp = $_FILES['image']['tmp_name'];
	
	$allowed_ext = array('jpg','jpeg','png','gif');
	$image_ext = strtolower(end(explode('.',$image_name)));
	
	$album_id=$_POST['album_id'];
	
	$errors=array();
	if(empty($image_name) || empty($album_id)) {
		$errors[]="Choose an Image and an Album";
	}
	else{
		if(in_array($image_ext,$allowed_ext)=== FALSE) {
			$errors[]='File type not allowed';		
		}
		if ($image_size > 2097152){
		 $errors[]='Maximum file size is 2MB';
		}
		if (album_check($album_id) === false) {
			$errors[]='Couldn\'t upload to that album';
		}
		
		if (!empty($errors)){
		foreach ($errors as $error){
		echo $error, '<br />';
		}
		}
		else{
			$user_data_first=$user_data['first_name'];
			$user_data_second=$user_data['second_name'];
			upload_image($image_temp,$image_ext,$album_id,$user_data_first,$user_data_second);
			die();
		}
	}


}
$albums=get_album();
if(empty($albums)){
	echo '<p>You don\'t have any album. <a href="create_album.php">Create an Album</a></p>';
}

else{ ?>
	<form action="" method="post" enctype="multipart/form-data">
		<p> Choose a file:<br /> <input type="file" name="image" /></p>
		<p>Choose an album:<br /> 
		<select name="album_id">
					<?php
					foreach($albums as $album) {
					echo '<option value="'.$album['id'].'">', $album['name'], '</option>';
					}?>
		</select></p>
					<p><input type="Submit" value="Upload Image" /></p>
	</form>
		
<?php
	
} 


?>




<?php
include "widgets/footer.php";
?>