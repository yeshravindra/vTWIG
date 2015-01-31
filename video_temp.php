<?php
include 'core/init.php';
$article_id=get_article_id();
$edit=check_if_article_belongs_to_user($article_id);
if ($edit==true){
$you_unique_id=$_GET['id'];
$insert="INSERT INTO video(video.article_id,video.id,video.time,video.vid_you_name)VALUES('$article_id','.$_SESSION[id].',NOW(),'$you_unique_id')";
mysql_query($insert);
header('Location:youtube_index.php?article='.$article_id.'&status='.$_GET['status'].'&id='.$you_unique_id);
}
?>