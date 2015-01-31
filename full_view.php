<style type="text/css">
		
</style>
<?php
include 'core/init.php';
$article_id=(int)$_GET['a'];
$video_id=$_GET['v'];
$query=(int)$_GET['q'];

if ($query==2){
?>
	<iframe width="710" height="440" src="http://www.youtube.com/embed/<?php echo $video_id;?>?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>
<?php
echo '<a href="view_article.php?article='.$article_id.'">back to article</a>';
}
?>