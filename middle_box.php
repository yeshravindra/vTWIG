<?php
$feature=(int)$_GET['feature'];
if ((!empty($feature))AND(isset($feature))){
include'widgets/feature_page.php'; 
}

 else{
echo '<a href="home.php?feature=1"><h3>Latest</h3></a>';
$latest_six=get_latest_six_articles();
foreach($latest_six as $latest){
	echo '<div id="home_article_list">';
	arrange_article($latest['article_id']);
	echo '</div>';
}

echo '<a href="home.php?feature=2"><h3>Most Read</h3></a>';
$most_read_six=get_most_read_six();
foreach($most_read_six as $most_read){
	echo '<div id="home_article_list">';
	arrange_article($most_read['article_id']);
	echo '</div>';
}

echo '<a href="home.php?feature=3"><h3>Recommended by People</h3></a>';
$recommended_six=get_most_recommended_six();
foreach($recommended_six as $recommended){
	echo '<div id="home_article_list">';
	arrange_article($recommended['article_id']);
	echo '</div>';
}



}
?>