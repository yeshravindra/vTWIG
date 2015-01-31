<?php
include 'core/init.php';
protect_page();
if (!isset($_GET['album_id']) || empty($_GET['album_id']) || album_check($_GET['album_id']) === false) {
header('Location:albums.php');
die();
}
include "widgets/header.php";
?>

<h3> Edit Album</h3>

<?php
	$album_id = $_GET['album_id'];
	$album_data=album_data($album_id,'name','description');
	if (isset($_POST['album_name'],$_POST['album_description'])){
		$album_name=$_POST['album_name'];
		$album_description=$_POST['album_description'];
		$errors=array();
		if (empty($album_name) || empty($album_description)){
		$ERRORS[]='Album name and Description required';
		} else{
			if (strlen($album_name)>55||strlen($album_description)>255){
				$errors[] = 'One or more fields contains too many characters';
			}
			if (!empty($error)){
				foreach ($errors as $error){
					echo $error, '<br />';
				}
			}	else {
			//echo $album_name;
				edit_album($album_id,$album_name,$album_description);
				header ('Location: albums.php');
			}
		}
	
	}

?>
<form action="?album_id=<?php echo $album_id; ?>" method="post">
	<p>Name:<br/> <input type="text" name="album_name" maxlength="55" 
	value="<?php echo $album_data['name']; ?>"/> </p>
	<p>Description: <br/> <textarea name="album_description" rows="6" cols="35" maxlength="255">
	<?php echo $album_data['description']; ?></textarea> </p>
	<p><input type="Submit" value="Edit Album"/></p>
</form>

<?php
include "widgets/footer.php";
?>