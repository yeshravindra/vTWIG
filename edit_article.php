<?php
include 'core/init.php';
protect_page();
include "widgets/header.php";
$article_id=(int)$_GET['article'];
$article_details=get_article_details_from_article_id($article_id);
$query=(int)$_GET['q'];
$edit=check_if_article_belongs_to_user($article_id);
if ($edit==false){
	header('Location:view_article.php?article='.$article_id);
	//header('Location:not_found.php');
	die();
}
$article_number=(int)($_POST['article_id']);
$article_name=htmlentities(mysql_real_escape_string($_POST['article_name']));
$article_description=htmlentities(mysql_real_escape_string($_POST['article_description']));
$article_tagging=htmlentities(mysql_real_escape_string($_POST['article_tagging']));
$article_copy1=(int)($_POST['copy']);
$article_div1=htmlentities($_POST['subdiv']);

if (!empty($article_number) AND !empty($article_name) AND !empty($article_description) AND !empty($article_tagging)){
		if ($edit==true){
			edit_this_article($article_id,$article_name,$article_description,$article_tagging,$article_div,$article_copy);
			echo "Success";
			header('Location:view_article.php?article='.$article_id);
			die();
			}
		else {
			header('Location:not_found.php');
			die();
		}
}
$page_name=htmlentities(mysql_real_escape_string($_POST['page_name']));
$page_content=htmlentities(mysql_real_escape_string($_POST['page_content']));
$page_id=(int)$_POST['page_id'];
if(!empty($page_name)AND!empty($page_content)AND!empty($page_id)){
	$select="UPDATE page SET page.page_name='".$page_name."',page.page_content='".$page_content."' WHERE page.page_id='".$page_id."'";
	mysql_query($select);
	header('Location:view_article.php?article='.$article_id);
	die();
}

$new_page_name=htmlentities(mysql_real_escape_string($_POST['new_page_name']));
$new_page_content=htmlentities(mysql_real_escape_string($_POST['new_page_content']));
$new_page_article_id=(int)$_POST['new_page_article_id'];
if(!empty($new_page_name)AND!empty($new_page_content)AND!empty($new_page_article_id)){
	$insert="INSERT INTO page(page.page_name,page.page_content,page.page_article)VALUES('$new_page_name','$new_page_content','$new_page_article_id')";
	mysql_query($insert);
	header('Location:view_article.php?article='.$article_id);
	die();
}

else{
if ($query==1)	{
		$article_details=get_article_details_from_article_id($article_id);
		?>
	<form action="" method="post" style="position:absolute;display:block;width750px;height:600px;background:#ffffff;top:0px;left:20px;">
	All fields are mandatory.</br>
	<a href="view_article.php?article='.$article_id" style="color:blue;" >Cancel and return</a>
	<textarea name="article_name" maxlength="100" title="Title" style="position:relative;width:600px;height:60px;color:#506488;font:bold 20px constania;"><?php echo $article_details[article_name];?></textarea></br>
	
	<textarea name="article_description" maxlength="700" title="Description"style="position:relative;width:600px;height:300px;color:#506488;font:bold 18px constania;"><?php echo $article_details[article_description];?></textarea></br>
		
	<textarea name="article_tagging" title="Tag(seperated by commas ',')" style="position:relative;width:600px;height:50px;color:#506488;font:bold 17px constania;"><?php echo $article_details[article_tagging];?></textarea></br>
	<?php get_drop_down_all_subdiv();?></br>
Please take a moment to read Copyright rules to avoid loss of contents and time.
			<select id="copyright" name="copy" style="width:700px;height:30px;font:bold 16px calibri; background:black;color:white;">
			<option value="0" title="Contents are open, can be reused,improved, developed but not duplicated. Users and algorithm filters out the duplicated data which reduces the reputation and the article may never showup in listing if found duplicate. Nevertheless, any PART of article can be developed or improved by others.">Standard vTWIG Licensing</option>
			<option value="1" title="Contents are not protected and may be removed upon Copyright claim. Cannot be used commercially unless approved by Owner">Reused from other sources, owner reserves rights</option>
			<option value="2" title="Content may be reused and developed for all commercial and non commercial purposes within vTWIG.com">Self generated content, Open source</option>
			<option value="3" title="Contents are reserved,others can use this for reference only. Author may claim Copyrights if used without permit.">Self generated content, All rights reserved</option>
			</select>	
	<input name="article_id" type="hidden" value="<?php echo $article_id;?>"/>
	<input id="" type="submit" value="Save changes" class="button_style1"/>
	</form>
	<?php
		die();
		}
if ($query==2) {
		//echo "edit cover page.";?>
		<div id="article_cover_page_upload">
			<form action="article_cover_page.php?article_number=<?php echo $article_id;?>" method="POST" enctype="multipart/form-data">
				<h3>Choose an image for article cover page.</h3>
				<input type="file" name="file"></br>
				<input type="submit" value="Change cover picture"></br>
				<a href="view_article.php?article=<?php echo $article_id; ?>">Cancel and return</a>
			</form>
		</div><?php
		die();
		}




if ($query==3){
		?>
		<div id="article_image_upload">
			<form action="article_image_upload.php?article_number=<?php echo $article_id;?>&q=1" method="POST" enctype="multipart/form-data">
				<h3>Choose an image to upload.</h3>
				<input type="file" name="file"></br>
				<input type="submit" value="Upload Image"></br>
				<a href="view_article.php?article=<?php echo $article_id; ?>">Cancel and return</a>
			</form>
		</div><?php
		die();


}

if ($query==4){
		$delete_image=(int)$_GET['i'];
		$delete_image_ext=htmlentities($_GET['e']);
		//echo '<a href="article_images/'.$article_id.'/'.$delete_image.'.'.$delete_image_ext.'">here</a>';
		unlink('article_images/'.$article_id.'/'.$delete_image.'.'.$delete_image_ext.'');
		
		unlink('article_images/'.$article_id.'/thumbs'.$delete_image.'.'.$delete_image_ext.'');
		delete_image($delete_image);
		header('Location:view_article.php?article='.$article_id);
		die();
}


if ($query==5){ // add video
	
	//include 'index.php';
	header('Location:youtube_index.php?article='.$article_id);
	die();
}

if ($query==6){ // move image
	$pixel=$_POST['pixel'];
	$image=(int)$_GET['i'];
	put_image_top($image, $pixel);
	header('Location:view_article.php?article='.$article_id);
	die();
}

if ($query==7){ // move video
	$pixel=$_POST['pixel'];
	$video=(int)$_GET['v'];
	put_video_top($video, $pixel);	
	header('Location:view_article.php?article='.$article_id);
	die();
}

if ($query==8){
	$page_id=(int)$_GET['pid'];
	$edit_page=check_if_page_belongs_to_article($page_id,$article_id);
	if($edit_page==true){
		$page_details=get_page_details($page_id);
		echo '<h3>'.$article_details['article_name'].'</h3>';
		echo '<form id="article_form" action="" method="POST">';
		echo '<textarea id="page_name" name="page_name" maxlength="32" title="Page name" style="width: 700px; margin-bottom:5px; font:bold 20px Bookman Old Style; ">'.$page_details[page_name].'</textarea></br>';
		echo '<textarea id="page_content" class="text_1024" name="page_content" maxlength="1000" title="Page Content" style="width: 700px; height:400px; margin-bottom: 5px; font:bold 20px Cooper Std;">'.$page_details[page_content].'</textarea></br>';
		echo '<input name="page_id" type="hidden" value="'.$page_id.'"></input>';
		echo '<input id="" type="submit" value="Save changes"></input>';
		echo '</form>';
	}
	else {
		header('Location:view_article.php?article='.$article_id);
	}
}



if ($query==9){
	echo '<h3>'.$article_details['article_name'].'</h3>';
	echo '<form id="new_page_form" action="" method="POST">';
	echo '<textarea id="article_name" type="text" class="input_signup" placeholder="PAGE HEAD" name="new_page_name" maxlength="32" style="width: 700px; margin-bottom: 5px;"></textarea></br>';
	echo '<textarea id="article_name" type="text" class="text_1024" placeholder="PAGE CONTENT,1024 characters each page" name="new_page_content" maxlength="1024" style="width: 700px; height:600px; margin-bottom: 5px;"></textarea><div id="char_left"></div></br>';
	echo '<input name="new_page_article_id" type="hidden" value="'.$article_id.'"></input>';
	echo '<input id="" type="submit" value="Save Page"/></form>';

}
if ($query==10){
	$vid=(int)$_GET['v'];
	mysql_query("DELETE FROM `video` WHERE `vid_id`=$vid AND `id`=".$_SESSION['id']."");
	header('Location:view_article.php?article='.$article_id);
}



}
?>