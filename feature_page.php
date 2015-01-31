<?php
$feature=(int)$_GET['feature'];
if ((empty($feature))AND(!isset($feature))){
//header('Location:home.php');
}
else{
	if ($feature==1){
		echo '<h3>Latest</h3>';
		$latest_all=get_latest_articles();
		foreach($latest_all as $latest_one){
			echo '<div id="home_article_list">';
			arrange_article($latest_one['article_id']);
			echo '</div>';
		}
		
	}
	
	if ($feature==2){
			echo '<h3>Most Read</h3>';
			$most_read_all=get_most_read_all();
			foreach($most_read_all as $most_read_one){
			echo '<div id="home_article_list">';
			arrange_article($most_read_one['article_id']);
			echo '</div>';
			}
	
	}
	
	if ($feature==3){
			echo '<h3>Recommended by People</h3>';
			$recommended_all=get_most_recommended_all();
			foreach($recommended_all as $recommended_one){
			echo '<div id="home_article_list">';
			arrange_article($recommended_one['article_id']);
			echo '</div>';
			}
	
	}
	
	
	
	

}

?>