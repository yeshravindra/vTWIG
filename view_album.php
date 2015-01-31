<?php
include "core/init.php";	
protect_page();
include "widgets/header.php";
?>
<div id="profile_align">
<a href="upload_image.php" title="Add Images to this Album"><br/>Add Images</a>
<?php
if (!isset($_GET['album_id']) || empty($_GET['album_id']) || album_check($_GET['album_id']) === FALSE){
	header('Location:albums.php');
	exit();
}
else { //remove this else if there is an issue
$album_id=$_GET['album_id'];
$album_data=album_data($album_id,'name','description');


echo '<h2>'.$album_data['name'].'</h2><p>'.$album_data['description'].'</p>';
	$album_id=$_GET['album_id'];
	$images=get_images($album_id);
	if(empty($images)){
		echo 'There are no images in this album';
	}
	else {
	
		//print_r($images);
		foreach ($images as $image) {
			$pic="uploads/".$image['album']."/".$image['id'].".".$image['ext'];
			$thumb="uploads/thumbs/".$image['album']."/".$image['id'].".".$image['ext'];
			echo '<a href="'.$pic.'">
			<img src="'.$thumb.'" title="Uploaded'.date('D M Y / h:i',$image['timestamp']).'"/></a> [<a href="delete_image.php?image_id='.$image['id'].'">x</a>]';
			
		}
	}

}
?>


<?php
include "widgets/footer.php";
?>