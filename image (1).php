<?php

function upload_image($image_temp,$image_ext,$album_id,$user_data_first,$user_data_second) {
	$album_id=(int)$album_id;
	mysql_query("INSERT into images (id,album_id,timestamp,ext)VALUES('".$_SESSION['id']."','".$album_id."',UNIX_TIMESTAMP(),'".$image_ext."')");
	$image_id=mysql_insert_id();
	$image_file=$image_id.'.'.$image_ext;
	move_uploaded_file($image_temp,"uploads/".$album_id."/".$image_file);
	//*****************************************  Water Marking Starts
	//$water="widgets/water_mark.php?source=uploads/".$album_id."/".$image_file;
	//header('Location:'.$water);
	header('Content-type:image/jpeg');
	$source = "uploads/".$album_id."/".$image_file;
	$watermark = imagecreatefrompng('widgets/logo.png');
	$watermark_height=imagesy($watermark);
	$watermark_width=imagesx($watermark);
	
	$image = imagecreatetruecolor($watermark_width,$watermark_height);
	if (($image = imagecreatefromjpeg($source))===FALSE){
	$image = imagecreatefrompng($source);
	}
		
	$image_size = getimagesize($source);
	$x= 10;
	$y= $image_size[1] - $watermark_height -10;
	//$x= $image_size[0] - $watermark_width -10;
	//$y= $image_size[1] - $watermark_height -10;
	
	imagecopymerge($image, $watermark, $x, $y, 0, 0, $watermark_width, $watermark_height, 20);
	imagejpeg($image, $source);
	//**************************************************USER MARK***********************************
	$display="credits:".$user_data_first." ".$user_data_second;
	$length=strlen($display)*9.3;
	$user_image = imagecreate($length,20);
	$background = imagecolorallocate($user_image,255,255,255);
	$foreground = imagecolorallocate($user_image,17,17,144);	
	imagestring($user_image,5,5,1,$display,$foreground);
	
	header('Content-type:image/jpeg');
	$user_mark="temp_pic/".$user_data_first.".jpg";
	imagejpeg($user_image,$user_mark);
	//**************************************** 
	$watermark = imagecreatefromjpeg($user_mark);
	$watermark_height=imagesy($watermark);
	$watermark_width=imagesx($watermark);
	
	$image = imagecreatetruecolor($watermark_width,$watermark_height);
	if (($image = imagecreatefromjpeg($source))===FALSE){
	$image = imagecreatefrompng($source);
	}
		
	$image_size = getimagesize($source);
	$x= 170;
	$y= $image_size[1] - $watermark_height -40;
	//$x= $image_size[0] - $watermark_width -10;
	//$y= $image_size[1] - $watermark_height -10;
	
	imagecopymerge($image, $watermark, $x, $y, 0, 0, $watermark_width, $watermark_height, 20);
	imagejpeg($image, $source);
	
	//****************************************Water Marking Ends******************************
	
	create_thumb('uploads/'.$album_id.'/',$image_file, 'uploads/thumbs/'.$album_id.'/');
	$locate="view_album.php?album_id=".$album_id;
	header('Location:'.$locate);
}


function get_images($album_id){
	$album_id=(int)$album_id;
	$images=array();
	$images_row=array();
	$image_query=mysql_query("SELECT `images`.`image_id`,`images`.`album_id`,`images`.`timestamp`,`images`.`ext` FROM `images` WHERE `images`.`album_id`='".$album_id."'");
	//echo "SELECT `images`.`image_id`,`images`.`album_id`,`images`.`timestamp`,`images`.`ext` FROM `images` WHERE `images`.`album_id`='".$album_id."'";
	
	while ($images_row = mysql_fetch_assoc($image_query)){
		$images[]=array(
					'id'=>$images_row['image_id'],
					'album'=>$images_row['album_id'],
					'timestamp'=>$images_row['timestamp'],
					'ext'=>$images_row['ext']
		);
	}
	return $images;
}

function image_check($image_id) {
	$image_id=(int)$image_id;
	$query= mysql_query("SELECT COUNT(`image_id`) FROM images WHERE image_id=$image_id AND id=".$_SESSION['id']."");
	return (mysql_result($query,0) == 0)?false:true;
}

function delete_image($image_id) {
	$image_id=(int)$image_id;
		mysql_query("DELETE FROM `images` WHERE `image_id`=$image_id AND `id`=".$_SESSION['id']."");
}

function get_image_top($image_id){
	$image_id=(int)$image_id;
	$select="SELECT images.image_top FROM images WHERE images.image_id='".$image_id."'";
	$query=mysql_result(mysql_query($select),0);
	return $query;
}

function put_image_top($image, $pixel){
	$select="UPDATE images SET images.image_top='".$pixel."' WHERE images.image_id='".$image."'";
	mysql_query($select);
}

function get_video_top($video){
	$video=(int)$video;
	$select="SELECT video.video_top FROM video WHERE video.vid_id='".$video."'";
	$query=mysql_result(mysql_query($select),0);
	return $query;
}

function put_video_top($video, $pixel){
	$select="UPDATE video SET video.video_top='".$pixel."' WHERE video.vid_id='".$video."'";
	mysql_query($select);
}


?>