<?php 
include ('article_images/thumb_2.php');
$tmp_name = $_FILES['file']['tmp_name'];
$article_number=(int)$_GET['article_number'];
if (isset($tmp_name)) {
	if (!empty($tmp_name)) {
		
		$location = "article_images/".$article_number."/";
					
	if (move_uploaded_file($tmp_name, $location.'article_cover_page.jpg')){
		$image="article_cover_page.jpg";
		mkdir ("article_images/".$article_number."/thumbs",0755);
		$destination=$location."thumbs/";
		//resize_cover_page($location, $image, $location);
		create_thumb_2($location, $image, $destination);
		header('Location:view_article.php?article='.$article_number);
		echo "Uploaded!!!";
		echo "<br /><a href='home.php'>Back to home page</a>";
		die();
		}
	}
	else{
		echo 'please choose a file';
	}
}
	//echo "<br /><a href='home.php'>Cancel and return (Note: All you changes will be lost)</a>";
?>

