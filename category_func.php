<?php

function get_12_articles_from_this_subdiv($subdiv_found){
$get_articles=array();
$select_get_articles="SELECT article.article_id,article.article_name,article.article_description,article.article_time,article.article_tagging FROM article WHERE article.article_subdiv LIKE'%$subdiv_found%' LIMIT 12";
$query_get_articles=mysql_query($select_get_articles);
while ($row=mysql_fetch_assoc($query_get_articles)) {
		$get_articles[]=array(
		'article_id'=>$row['article_id'],
		'article_name'=>$row['article_name'],
		'article_description'=>$row['article_description'],
		'article_time'=>$row['article_time'],
		'article_tagging'=>$row['article_tagging']);		
	}
	return $get_articles;
}



function get_category_from_subdiv($subdiv){
$get_category=array();
$select="SELECT categories.cat_id,categories.category FROM categories WHERE categories.subdiv='$subdiv'";
$get_category=mysql_fetch_assoc(mysql_query($select));
	return $get_category;
}

function get_drop_down_all_subdiv(){
		$select="SELECT categories.subdiv,CONCAT(categories.subdiv,' -> ',categories.category)as all_div FROM categories WHERE 1";
		$query=mysql_query($select);
		echo '<select class="drop_down_category_add_article_option" name="subdiv" style="width:500px; height:30px; color:white;text-transform:capitalize;font:bold 15px calibri">';
		while (($row=mysql_fetch_assoc($query))!==false) {
				$subdiv_found=$row['all_div']; 
				$sub_only=$row['subdiv'];
				echo '<option value="'.$sub_only.'" >'.$subdiv_found.'</option>';
		}
		echo '</select>';
}

function add_article_to_this_subdiv($subdiv,$article_name,$article_description,$article_tagging,$article_copy){
$insert_into="INSERT INTO article(article.article_name,article.article_description,article.article_time,article.article_subdiv,article.article_tagging,article.article_author_id,article.copyright)VALUES('$article_name','$article_description',NOW(),'$subdiv','$article_tagging','".$_SESSION['id']."','$article_copy')";
$query_insert=mysql_query($insert_into);
mkdir ("article_images/".mysql_insert_id(),0755);
mkdir ("article_images/".mysql_insert_id()."/thumbs",0755);
$article_id=mysql_insert_id();
return $article_id;
}


function get_article_details_from_article_id($article_id){
$select="SELECT article.article_name,article.article_description,article.article_time,article.article_subdiv,article_tagging,article.article_author_id,article.hit_counter FROM article WHERE article.article_id='$article_id'";
$article_details=mysql_fetch_assoc(mysql_query($select));
if(!empty($article_details)){
return($article_details);
}
else {
	header('Location:home.php');
	die();
}
}

function check_if_category_exists($category){
$select="SELECT COUNT(categories.category) FROM categories WHERE categories.category='$category'";
$query=mysql_query($select);
if (mysql_result($query,0)==0){
	echo "Thats an invalid category";
	die();
}
else {
	echo '<h1>'.$category.'</h1>';
}
}

function check_if_article_belongs_to_user($article_id) {
	$article_id=(int)$article_id;
		$query = mysql_query("SELECT COUNT('article.article_id') FROM article WHERE article.article_id=$article_id AND article.article_author_id=".$_SESSION['id']."");
		return (mysql_result($query,0)==1) ? 1 : 0;

}

function edit_this_article($article_id,$article_name,$article_description,$article_tagging,$article_div,$article_copy){
	$select="UPDATE article SET article.article_name='".$article_name."' , article.article_description='".$article_description."' , article.article_tagging='".$article_tagging."' , article.article_subdiv='".$article_div."' ,article.copyright='".$article_copy."' WHERE article.article_id=$article_id";
	$query=mysql_query($select);
	echo mysql_error();
}



function article_image_upload($image_temp,$image_ext,$article_number,$user_data_first,$user_data_second) {
	$article_number=(int)$article_number;
	mysql_query("INSERT into images (id,album_id,timestamp,ext)VALUES('".$_SESSION['id']."','".$article_number."',UNIX_TIMESTAMP(),'".$image_ext."')");
	$image_id=mysql_insert_id();
	$image_file=$image_id.'.'.$image_ext;
	move_uploaded_file($image_temp,"article_images/".$article_number."/".$image_file);
	//*****************************************  Water Marking Starts
	//$water="widgets/water_mark.php?source=uploads/".$article_number."/".$image_file;
	//header('Location:'.$water);
	header('Content-type:image/jpeg');
	$source = "article_images/".$article_number."/".$image_file;
	$watermark = imagecreatefromgif('widgets/logo.gif');
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
	$display="All Rights:".$user_data_first." ".$user_data_second;
	$length=strlen($display)*9.3;
	$user_image = imagecreate($length,20);
	$background = imagecolorallocate($user_image,255,255,255);
	$foreground = imagecolorallocate($user_image,17,17,144);	
	imagestring($user_image,5,5,1,$display,$foreground);
	
	header('Content-type:image/gif');
	$user_mark="temp_pic/".$user_data_first.".gif";
	imagegif($user_image,$user_mark);
	//**************************************** 
	$watermark = imagecreatefromgif($user_mark);
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
	//mkdir ('article_images/'.$article_number.'/thumbs/image_'.$image_number.'/');
	create_thumb_article_image_1('article_images/'.$article_number.'/',$image_file, 'article_images/'.$article_number.'/thumbs/');
	//$locate="view_album.php?album_id=".$article_number;
	//header('Location:'.$locate);
}


	function view_article_annotate($article_id){
		$article_id=(int)$article_id;
		$view_art_annotates=array();
		$select="SELECT annotate_article.art_ann_id, annotate_article.art_ann_text,annotate_article.id,annotate_article.art_ann_time FROM annotate_article WHERE annotate_article.article_id='".$article_id."' ORDER BY annotate_article.art_ann_time";
		$query=mysql_query($select);
		while($view_art_annotates=mysql_fetch_assoc($query)){
			$view_all_annotates[]=$view_art_annotates;
		}
		return($view_all_annotates);
	}


	function article_hit_count($article_id){
	$select="SELECT article.hit_counter FROM article WHERE article.article_id='".$article_id."'";
	$select_query=mysql_query($select);
	$hit_count=mysql_result($select_query,0);	
	$hit_count=$hit_count+1;
	$insert="UPDATE article SET article.hit_counter=('".$hit_count."') WHERE article.article_id='".$article_id."'";
	$update_query=mysql_query($insert);
	
	return $hit_count;	
	}
	
	function insert_article_id($article_id){
	$select="UPDATE table2 SET table2.temp_storage='".$article_id."' WHERE table2.id='".$_SESSION['id']."'";
	mysql_query($select);
	}
	
	function get_article_id(){
	$select="SELECT table2.temp_storage FROM table2 WHERE table2.id='".$_SESSION['id']."'";
	$query=mysql_result(mysql_query($select),0);
	return $query;
	}
	
	function get_videos_of($article_id){
	$article_id=(int)$article_id;
	$select="SELECT video.vid_id,video.article_id,video.time,video.vid_you_name FROM video WHERE video.article_id='".$article_id."' LIMIT 3";
	$query=mysql_query($select);
	while ($you_video_names = mysql_fetch_assoc($query)){
		$all_video_names[]=array(
					'vid_id'=>$you_video_names['vid_id'],
					'time'=>$you_video_names['time'],
					'vid_you_name'=>$you_video_names['vid_you_name']
		);
	}
	return $all_video_names;
		
	}
	
function get_pages_from_article($article_id){
	$select="SELECT page.page_id,page.page_name,page.page_content FROM page WHERE page.page_article='".$article_id."'";
	$query=mysql_query($select);
	while ($pages=mysql_fetch_assoc($query)){
		$all_pages[]=array(
			'page_id'=>$pages['page_id'],
			'page_name'=>$pages['page_name'],
			'page_content'=>$pages['page_content']
		);
	}
	return($all_pages);
}

function get_article_content_page_wise_to_edit($article_id,$max_pages){
$all_pages=get_pages_from_article($article_id);
$page=(int)$_GET['page'];
if((empty($page))OR(!isset($page))){
	$page=0;
echo '<h2>'.$all_pages[$page]['page_name'].'</h2><h6><a href="edit_article.php?article='.$article_id.'&q=8&pid='.$all_pages[$page]['page_id'].'">edit page'.($page+1).'</a></h6></br>';
echo '<h4 style="font:13px calibri;">'.$all_pages[$page]['page_content'].'</h4></br>';
}
else{
echo '<h2>'.$all_pages[$page-1]['page_name'].'</h2><a id="aj_e_p" href="edit_article.php?article='.$article_id.'&q=8&pid='.$all_pages[$page-1]['page_id'].'">edit page</a></br>';
echo '<h4>'.$all_pages[$page-1]['page_content'].'</h4><br/>';
if (isset($all_pages[$page]['page_name'])){
echo '<h2>'.$all_pages[$page]['page_name'].'</h2><a id="aj_e_p" href="edit_article.php?article='.$article_id.'&q=8&pid='.$all_pages[$page]['page_id'].'">edit page</a><br/>';
echo '<h4>'.$all_pages[$page]['page_content'].'</h4><br/>';
}
}
}

function get_article_content_page_wise_to_view($article_id){
$all_pages=get_pages_from_article($article_id);
$page=(int)$_GET['page'];
if((empty($page))OR(!isset($page))){
	$page=0;
echo '<h2>'.$all_pages[$page]['page_name'].'</h2></br>';
echo '<h4>'.$all_pages[$page]['page_content'].'</h4></br>';
}
else{
echo '<h2>'.$all_pages[$page-1]['page_name'].'</h2></br>';
echo '<h4>'.$all_pages[$page-1]['page_content'].'</h4></br>';
echo '<h2>'.$all_pages[$page]['page_name'].'</h2></br>';
echo '<h4>'.$all_pages[$page]['page_content'].'</h4></br>';
}
}


function check_if_page_belongs_to_article($page,$article_id){
	$select="SELECT COUNT(page.page_id) FROM page WHERE page.page_id='".$page."' AND page.page_article='".$article_id."'";
	$query=mysql_query($select);
	return(mysql_result($query,0)==1) ? true : false;
}

function get_page_details($page){
	$select="SELECT page.page_name,page.page_content FROM page WHERE page.page_id='".$page."'";
	$query=mysql_query($select);
	$p['page_name']=mysql_result($query,0);
	$p['page_content']=mysql_result($query,0,1);
	return $p;
}
function get_no_of_pages($article_id){
	$select="SELECT COUNT(page.page_id) FROM page WHERE page.page_article='".$article_id."'";
	return mysql_result(mysql_query($select),0);
}
?>