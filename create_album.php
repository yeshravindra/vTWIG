<?php
include 'core/init.php';
protect_page();
include "widgets/header.php";
?>

<h3>Create Album</h3>
<form action="" method="post">
	<p>Name:<br/> <input type="text" name="album_name" maxlength="55"/> </p>
	<p>Description: <br/> <textarea name="album_description" rows="6" cols="35" maxlength="255"></textarea> </p>
	<p><input type="Submit" value="Create Album"/></p>
</form>
<?php
if (isset($_POST['album_name'],$_POST['album_description'])) {
	$album_name = $_POST['album_name'];
	$album_description = $_POST['album_description'];
	$errors = array();
	
	if (empty($album_name) || empty($album_description)) {
		$errors[] ='Album Name and Description reaquired';
	} 
	else if (strlen($album_name) > 55 || strlen($album_description) > 255) {
		$errors[]='One or more fields contains too many characters';
	} 
	
	if (!empty($errors)) {
		foreach ($errors as $error) {
			echo $error, '<br />';
		}
	}	
	else {
		create_album($album_name, $album_description);
		echo "Successfully Created!";
		header ('Location:albums.php');
	
	}
}


?>




<?php
include "widgets/footer.php";
?>