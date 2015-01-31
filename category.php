<?php
include 'core/init.php';

if (!isset($_GET['category']) || empty($_GET['category'])){
	header('Location:home.php');
	exit();
}
else{
$category=$_GET['category'];
$category=htmlentities(mysql_real_escape_string($category));
$category_select="SELECT categories.subdiv FROM categories WHERE categories.category='".$category."'";
$category_query=mysql_query($category_select);?><div id="category_b2y"><?php
echo '<h2>'.$category.'</h2>';	
if (logged_in()==true){
	$action1='add_article.php?category=$category';
	?>	<form action="<?php echo $action1;?>" method="GET" >
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input class="add_article_button" type="submit" value="add article"/>
		</form>
	<?php	
}
else {
	?>		<form action="login_or_register.php" method="GET" >
		<input type="hidden" name="n" value="add_article.php?category=<?php echo $category;?>">
		<input class="add_article_button" type="submit" value="add article"/>
		</form>
	<?php	
}

while (($row=mysql_fetch_assoc($category_query))!==false) {
	$subdiv_found=$row['subdiv']; echo '</br>';

	echo '<h3>'.$subdiv_found.'</h3>';
	$get_articles=get_12_articles_from_this_subdiv($subdiv_found);
	if ((empty($get_articles[0]))AND(!isset($get_articles[0]))){
		echo '<h5>No articles in this division yet</h5><br /><br />';
	}
	else{
	foreach ($get_articles as $articles_id){
	echo '<div id="cat_art_arr">';
		arrange_article($articles_id['article_id']);
	echo '</div>';	
	}
}
} echo '</div>';
}
?>
<script>
$('.article_list_box').mouseenter(function(){
	$('#b_art_title',this).stop().animate({ 'top': -140 },800);
});
$('.article_list_box').mouseleave(function(){
	$('#b_art_title',this).stop().animate({ 'top': -35 },800);
});
</script>