<?php
function check_if_user_has_display_box($user_id){
	$select="SELECT COUNT(display_box.owner_id) FROM display_box WHERE display_box.owner_id='$user_id'";
	return (mysql_result(mysql_query($select),0)==1)? true:false;	
}
function check_if_box_is_taken($box_name){
	$select="SELECT COUNT(display_box.box_name) FROM display_box WHERE display_box.box_name='$box_name' AND display_box.owner_id!='".$_SESSION['id']."'";
	return (mysql_result(mysql_query($select),0)==1)? true:false;
}

function check_box_for_this_user_id($user_id){
	$select="SELECT display_box.box_id,display_box.box_name,display_box.box_description FROM display_box WHERE display_box.owner_id=$user_id";
	$query=mysql_query($select);
	$query=mysql_fetch_assoc($query);
	return($query);
}

function arrange_article($article_id){
	$article=get_article_details_from_article_id($article_id);
	$box=check_box_for_this_user_id($article[article_author_id]);
	$box_owner_name=first_second_from_id($article[article_author_id]);
	$box_owner_username= username_from_id($article[article_author_id]);	
	$time=getRelativeTime($article[article_time]);
	$art_image='article_images/'.$article_id.'/thumbs/article_cover_page.jpg';
	if (!(file_exists($art_image))){
		$art_image="article_images/default/thumb/article_cover_page.gif";
	}
	if (empty ($box[box_name])){
		$box[box_name]=$box_owner_name;
	}

	echo '<div class="article_list_box" article="'.$article_id.'">';
	echo '<a href="view_article.php?article='.$article_id.'">';
	echo '<img id="article_list_image_s_2" src="'.$art_image.'"/>';
	echo '<div id="b_art_title" >';
	echo '<h4 title="'.$article[article_name].'">'.$article[article_name].'</h4>';
	echo '<h5>'.$article[article_description].'</h5>';
	echo '<h6 title="'.$box_owner_name.'"><a id="article_list_owner_s_2"href="display_box.php?user='.$box_owner_username.'">'.$box[box_name].'</a></h6>';
	echo '<p>'.$time.'</p>';
	echo '<li>Reads:'.$article[hit_counter].'</li>';
	echo '</div></div></a>';
	//print_r($article);
	}

function get_articles_for_this_user($user_id){
	$select="SELECT article.article_id FROM article WHERE article.article_author_id='".$user_id."' ORDER BY article.article_time DESC";
	$query=mysql_query($select);
	while ($row = mysql_fetch_assoc($query)){
			$article_all[]=array(
				'article_id'=>$row['article_id']
			);
	}
		//print_r($article_all);
		return($article_all);
}
	
function get_latest_six_articles(){
	$select="SELECT article.article_id FROM article ORDER BY article.article_time DESC LIMIT 6";
	$query=mysql_query($select);
	while ($row = mysql_fetch_assoc($query)){
			$latest_six[]=array(
				'article_id'=>$row['article_id']
			);
	}
		return $latest_six;
	
}

function get_latest_articles(){
	$select="SELECT article.article_id FROM article ORDER BY article.article_time DESC LIMIT 20";
	$query=mysql_query($select);
	while ($row = mysql_fetch_assoc($query)){
			$latest_all[]=array(
				'article_id'=>$row['article_id']
			);
	}
		return $latest_all;
}

function get_most_read_six(){
	$select="SELECT article.article_id FROM article ORDER BY article.hit_counter DESC LIMIT 6";
	$query=mysql_query($select);
	while ($row = mysql_fetch_assoc($query)){
			$top_six[]=array(
				'article_id'=>$row['article_id']
			);
	}
		return $top_six;
}

function get_most_read_all(){
		$select="SELECT article.article_id FROM article ORDER BY article.hit_counter DESC LIMIT 20";
	$query=mysql_query($select);
	while ($row = mysql_fetch_assoc($query)){
			$top_all[]=array(
				'article_id'=>$row['article_id']
			);
	}
		return $top_all;
}

function get_most_recommended_six(){
	$select="SELECT article.article_id FROM article ORDER BY CHAR_LENGTH(article.voter_ids) DESC LIMIT 6";
	$query=mysql_query($select);
	while ($row = mysql_fetch_assoc($query)){
			$top_six[]=array(
				'article_id'=>$row['article_id']
			);
	}
		return $top_six;
}

function get_most_recommended_all(){
	$select="SELECT article.article_id FROM article ORDER BY CHAR_LENGTH(article.voter_ids) DESC LIMIT 20";
	$query=mysql_query($select);
	while ($row = mysql_fetch_assoc($query)){
			$top_all[]=array(
				'article_id'=>$row['article_id']
			);
	}
		return $top_all;
}

function get_articles_from_keyword($keyword){
	$select="SELECT article.article_id FROM article WHERE (article.article_name) LIKE '%$keyword%' LIMIT 30";
	$query= mysql_query($select);
	while ($row = mysql_fetch_assoc($query)){
			$top_all[]=array(
				'article_id'=>$row['article_id']
			);
	}
		return $top_all;
}
?>