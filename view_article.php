<?php
include 'core/init.php';
include 'widgets/header.php';

$article_id=$_GET['article'];
$article_id=(int)$article_id;
if (($article_id==0) OR (!isset($article_id))){
	header('Location:home.php');
}
else{
$article_details=get_article_details_from_article_id($article_id);
if (isset($_SESSION['id'])){
$hitter_id=$_SESSION['id'];
}
else {
$hitter_id=0;
}
$hit_count=article_hit_count($article_id);
$author_name=ucwords(first_second_from_id($article_details['article_author_id']));
$author_username=username_from_id($article_details['article_author_id']);
$edit=check_if_article_belongs_to_user($article_id);
$box=check_box_for_this_user_id($article_details['article_author_id']);
$box_name=$box[box_name];
$max_pages=get_no_of_pages($article_id);
if (!isset($box_name)OR empty($box_name)){
	$box_name=$author_username;
}
$view_img='article_images/'.$article_id.'/article_cover_page.jpg';
if (!(file_exists($view_img))){
				$view_img='article_images/default/article_cover_page.jpg';
			}

?>
<div id="view_panel"style="position:relative;width:750px;height:500px;background:#506488;overflow:hidden;">

<img src="<?php echo $view_img;?>" style="position:relative;top:10px;left:10px;width:730px;height:480px;"></img>

<div id="j_desc_art"style="position:absolute;width:240px;height:450px;left:500px;top:10px;background-color:#000000;background-color: rgba(0,0,0,0.5);">
<h4 style="position:absolute;left:20px;top:0px;color:white;font: bold 15px constania;">Description:</h4>
<div style="position:relative;left:20px;top:50px;color:white; font:14px constania; width:200px;word-wrap:break-word;overflow:hidden;"><?php echo $article_details['article_description'];?></div></div>
<div id="j_title"style="position:absolute;width:490px;min-height:40px;left:10px;top:50px;background-color:#000000;background-color: rgba(0,0,0,0.5);">
<h2 style="color:white;font:bold 20px constania;text-align:center;"><?php echo $article_details['article_name'];?></h2></div>
<?php
echo '<div id="j_owner"style="position:absolute;width:750px;height:40px;left:0px;top:460px;background:black; background-color:#000000;background-color:rgba(0,0,0,0.7);z-index:200;">

<div id="clear_cover"style="position:absolute;display:block;background-image:url(templates/media/clr1.gif); width:36px;height:30px;left:650px;top:5px;cursor:pointer;z-index:103;"></div>
<div id="full_screen"style="position:absolute;display:block;background-color:#b8b9bc;background-image:url(templates/media/full_scr.gif); width:36px;height:30px;left:700px;top:5px;cursor:pointer;"></div><div id="j_prev" title="Previous page" style="position:absolute;display:none;background-color:#b8b9bc;background-image:url(templates/media/prev.gif); width:30px;height:30px;left:550px;top:5px;cursor:pointer;color:black;"></div><div id="j_next" title="Next page" style="position:absolute;display:none;background-color:#506488;background-image:url(templates/media/next.gif); width:30px;height:30px;left:600px;top:5px;cursor:pointer;color:black;"></div><div id="j_continue_reading" style="position:absolute;display:block;width:146px;height:38px;left:450px;top:1px;cursor:pointer;background-image:url(templates/media/continue.gif);background-color:#f2c11e;"></div>';
$pages=get_pages_from_article($article_id,$max_pages);
echo '<select id="j_select_page" style="position:absolute;display:block;background-color:#000000; width:400px;height:30px;left:20px;top:5px;cursor:pointer;text-align:center;color:white;font:bold 14px constania;">';
$page_no=1;
echo '<option value="0">Cover page</option>';
foreach($pages as $page){
echo '<option value="'.$page_no.'">'.$page['page_name'].'</option>';
$page_no=$page_no+1;
}
echo '</select>';

echo '</div> 
<div id="j_page" style="position:absolute;width:710px;left:20px;top:30px;height:430px;background:#ffffff;display:none;background-color:#ffffff;background-color: rgba(255,255,255,0.9);"><div style="margin:10px;"><div id="loading_page" style:"display:none;text-align:center;">Loading pages...<img src="templates/media/328.gif"/><br/>';if ($browser=='ie'){echo 'Try Chrome, Mozilla or Safari to experience <br/> this website faster...';} echo '</div>';
$images=get_images($article_id);$you_video_names=get_videos_of($article_id);
if ((empty($images) OR !isset($images))AND((empty($you_video_names))OR(!isset($you_video_names)))){
echo '<div  id="j_scroll" style="height:420px;width:720px;overflow:hidden;overflow-y:auto;"><div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div><pre id="j_content" width="75px" style="width:630px;height:auto;word-wrap:break-word;"><div class="viewport"><div class="overview">';
}
else {
echo '<div id="j_scroll" style="height:420px;width:720px;overflow:hidden;overflow-y:auto;"><div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div><pre id="j_content" width="69px" style="width:470px;height:auto;word-wrap:break-word;"class="viewport"><div class="overview">';
}

echo '</div></pre><div id="j_image_scroll"style="position:absolute;top:0px;width:170px;left:525px;height:420px;overflow:hidden;overflow-y:auto;"><div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div><div class="viewport"><div  class="overview" >';
foreach ($you_video_names as $video_name){ ?>
					<div id="j_video" onclick="video_style1('<?php echo $video_name['vid_you_name'];?>')" style="cursor:pointer;width:150px;height:100px;overflow:hidden;"><img src="http://i1.ytimg.com/vi/<?php echo $video_name['vid_you_name'];?>/default.jpg" style="position:relative;top:0px;left:0px;width:150px;height:100px;"/><img src="templates/media/play.gif" style="position:relative;top:-60px;left:60px;"/></div>
<?php 					
					if ($edit== true){	
					echo '<a href="edit_article.php?article='.$article_id.'&q=10&v='.$video_name['vid_id'].'" id="j_remove_vid" title="remove this video"style="position:relative;top:-100px;left:130px;color:#506488;">[x]</a>';
					}
		 }

foreach ($images as $image) {
	echo '<a href="article_images/'.$article_id.'/'.$image['id'].'.'.$image['ext'].'">
				<img src="article_images/'.$article_id.'/thumbs/'.$image['id'].'.'.$image['ext'].'"  style="position:relative;top:10px;left:0px;width:150px;height:100px;" /><br/>
				</a>';
		if ($edit== true){
		echo '<a href="edit_article.php?article='.$article_id.'&q=4&i='.$image['id'].'&e='.$image['ext'].'" title="remove this image"style="position:relative;top:-95px;left:130px;color:#506488;">[x]</a>';}
};
echo '</div></div></div></div></div></div></div>';

echo '<div style="position:absolute;display:block;top:505px;background:white;left:0px;width:750px;height:auto;"> <div style="position:relative;display:inline-block;display:inline;left:30px;top:10px;color:grey;font:1em constania;" title="'.$author_name.' : 
'.$box[box_description].'">Published by: <a href="display_box.php?user='.$author_username.'" style="font:1em constania;color:#506488;">'.$box_name.'</a> '.getRelativeTime($article_details[article_time]).'</div>
<div style="position:absolute;display:inline-block;display:inline;left:520px;top:5px;color:#506488;font:2em constania">'.$hit_count.'<div style="position:relative;display:inline-block;display:inline;left:0px;top:0px;color:#506488;font:0.5em calibri">hits</div></div><div style="position:absolute;display:inline-block;display:inline;left:520px;top:35px;color:#506488;font:1em calibri"><div  id="j_and_other" style="position:absolute;display:none;left:-63px;top:15px;color:#506488;font:1em calibri">and other</div><div style="position:relative;display:inline-block;display:inline;font:2em constania;top:2px;">'.count_vote_for_article($article_id).'</div><h5 style="position:relative;display:inline-block;display:inline;left:0px;top:0px;color:#506488;font:1em calibri">people twigs this</h5></div>';

$vote_enable=check_vote_for_article($user_data['id'],$article_id);
if ($vote_enable==false){
						if (logged_in()==true){  
							echo '<div id="j_vote1" style="position:relative;display:inline-block;display:inline;left:100px;top:42px;color:#506488;font:1.5em calibri;cursor:pointer;">twig it</div>';
							
						}
							else { echo '<div id="j_vote2"style="position:relative;display:inline-block;display:inline;left:100px;top:42px;font:1.5em calibri;color:#506488;cursor:pointer;width:150px;">twig it</div>';
							}
			}
else {
	echo '<div style="position:relative;display:inline-block;display:inline;left:170px;top:42px;color:#506488;font:1.5em calibri" >You<h2 style="position:absolute;left:43px;top:-4px;color:#506488;font:15px calibri;width:60px;">and other</h2></div>';
}
echo '<div  id="j_log_view" style="position:relative;display:none;background:#506488;width:600px;height:60px;top:40px;left:50px;">
<form action="login.php?n=view_article.php?article='.$article_id.'" method="post">			
<input style="width:200px;height:25px;left:10px;top:5px;position:absolute;" type="text" name="user_name" placeholder="User Name or Email"/><br>			
<input style="width:200px;height:25px;left:220px;top:5px;position:absolute;" type="password" name="password" placeholder="Password"/><br>
<input style="position:absolute;height:32px;left:450px;top:20px;" type="submit" value="Log In"class="button_style1"/>			
</form>
<a href="login_or_register.php" style="position:absolute;left:250px;top:37px;display:inline;display:inline-block;color:white;">Create a new account</a>
</div>';

if ($edit== true){
			echo '<div style="position:relative;display:block;top:60px;left:0px;width:750px;height:30px;">';
			
				echo '<a href="edit_article.php?article='.$article_id.'&q=1" class="button_style1" style="height:10px;width:100px;display:block;" title="edit article">Edit article</a>';
				
				echo '<a href="edit_article.php?article='.$article_id.'&q=2" class="button_style1" style="position:absolute;top:0px;left:105px;height:10px;width:100px;display:block;" title="Change cover page">Change cover</a>';
				echo '<a href="edit_article.php?article='.$article_id.'&q=3" class="button_style1" style="position:absolute;top:0px;left:210px;height:10px;width:100px;display:block;" title="Add an image">Image</a>';
				echo '<a href="edit_article.php?article='.$article_id.'&q=5" class="button_style1" style="position:absolute;top:0px;left:315px;height:10px;width:100px;display:block;" title="Add a video">Video</a>';				
				echo '<a href="edit_article.php?article='.$article_id.'&q=9" class="button_style1" style="position:absolute;top:0px;left:420px;height:10px;width:100px;display:block;" title="add page">Add page</a>';
			echo '</div>';
		}




echo '<div id="j_talks" style="background:#ffffff;position:relative;display:block;top:40px;left:0px;width:750px;height:auto;">
		<h3 style="position:relative;top:10px;left:30px;color:#506488;font:1.3em constania;">Talks</h3>';
		if (logged_in()==true){
		$do_annotate_article="do_annotate.php?article_id=".$article_id."&q=2";
		}
		else {
		$do_annotate_article='login_or_register.php?n=view_article.php?article='.$article_id;
		}
?>

		<form id="do_annotate_article_form" action="<?php echo $do_annotate_article;?>" method="post" style="position:relative;top:0px;left:10px;">
		<textarea class="textarea" onblur="if(this.value=='') this.value='Say something about this article..';" onfocus="if(this.value=='Say something about this article..') this.value='';" name="annotate_text_article"
		style="color:#506488;width:500px;height:30px;">Say something about this article..</textarea>
		<input type="submit" value="Say it!" class="button_style1" style="position:relative;top:-10px;left:30px;"/>
		</form>
		
<?php
		$view_art_annotates=view_article_annotate($article_id);
		if (isset($view_art_annotates) AND (!empty($view_art_annotates))){
		foreach ($view_art_annotates as $view_art_annotate){
			echo '<br /><div style="position:relative;top:0px;left:20px;min-height:100px;">';
				echo '<div style="position:relative;top:0px;height:auto;width:600px;left:10px;color:#595a5c;">'.$view_art_annotate['art_ann_text'].'</div>';
				$annotator_id=$view_art_annotate['id'];
					$annotator_first_second=first_second_from_id($annotator_id);
					$annotator_username=username_from_id($annotator_id);
					$annotator_link="display_box.php?user=$annotator_username";
					$thumb_pic="user_profiles/".$annotator_username."/thumb/profilepic.jpg";
				echo '<div id="article_annotate_time"style="position:relative;top:0px;color:grey;font:bold 10px calibri;" >'.getRelativeTime($view_art_annotate['art_ann_time']).' <a href='.$annotator_link.' style="color:#506488;text-transform:capitalize;font:bold 11.5px calibri;">'.$annotator_first_second.'</a></div>';				
				echo '<img src="'.$thumb_pic.'"style="position:absolute;top:0px;left:620px;width:50px;border:1px solid #506488;"alt="image"></img>';
				echo '</div>';
				}
			}
			else {
			echo '<h3 style="position:relative;left:20px;font:bold 15px calibri;color:#b8b9bc;">Be the first to comment on this.</h3>';
			};
		echo '</div></div>';


 } 
 ?>
 
<script>
var a=<?php echo $article_id;?>;
var mp=<?php echo $max_pages;?>;						
var ezj=<?php echo $edit;?>;
</script>
<script type="text/javascript" src="js/view.js"></script>
<script type="text/javascript" src="js/scroll_bar.js"></script>
<script>
function video_style1(vid){
q=2;
//alert(vid);
/*$.get
$.get('aJ_l0Ad.php', { article:a, page:p, yedz:ezj },function (data){
	$('#loading_page').hide();
	$('#j_content').html(data);
});
$.get('full_view.php', { v:vid, q:q },function (data){
	$('#j_page').html(data);
});*/
$.ajax({	
	url: 'full_view.php?q=2&v='+vid,
	success:function(data){
		$('#j_page').html(data);
	}	
	});


}
</script>