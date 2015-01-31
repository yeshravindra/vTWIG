
<?php
include "core/init.php";	
protect_page();
include "widgets/header.php";
?>

<h3>To upload an Image</h3>
<?php	
$tmp_name = $_FILES['file']['tmp_name'];
$article_number=(int)$_GET['article_number'];

if (isset($tmp_name)){	
	$image_name = $_FILES['file']['name'];
	$image_size = $_FILES['file']['size'];
	$image_temp = $_FILES['file']['tmp_name'];
	
	$allowed_ext = array('jpg','jpeg','png','gif');
	$image_ext = strtolower(end(explode('.',$image_name)));
	
	//$album_id=$_POST['album_id'];
	
	$errors=array();
	if(empty($image_name)) {
		echo $errors[]="Choose an image first";
		header('Location:view_article.php?article='.$article_number);
		die();
	}
	else{
		if(in_array($image_ext,$allowed_ext)=== FALSE) {
			$errors[]='File type not allowed';		
		}
		if ($image_size > 2097152){
		 $errors[]='Maximum file size is 2MB';
		}
		
		
		if (!empty($errors)){
		foreach ($errors as $error){
		echo $error, '<br />';
		}
		
		}
		
		else{
			$user_data_first=$user_data['first_name'];
			$user_data_second=$user_data['second_name'];
			
			if (!empty($tmp_name)) {
			//$image_number=1;
			//$make_dir=mkdir ("article_images/".$article_number."/image_".$image_number."/");
			//$check_dir=("../article_images/".$article_number."/image_".$image_number."/");
			
			/*
			while (!mkdir ("article_images/".$article_number."/image_".$image_number."/")){
			
			$image_number=$image_number+1;				
				}*/
	
			article_image_upload($image_temp,$image_ext,$article_number,$user_data_first,$user_data_second);
			header('Location:view_article.php?article='.$article_number);
			//die();
				}
		}
	}



}
?>


<?php
include "widgets/footer.php";
?>