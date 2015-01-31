<?php
include 'core/init.php';
$user_id=(int)$_SESSION['id'];
$current_ties=get_current_ties($user_id);
$list_ties=explode(',', $current_ties);
$i=1;
foreach($list_ties as $list){
	if (!($list==0)){
		$arts=get_articles_for_this_user($list);
		sort($arts);
		foreach($arts as $art){
			$art2=$art[article_id];
			$article[$i]=$art2;
			$i=$i+1;
		}
	}
}
rsort($article);
$t=0;
echo '<div id="#people_updates_article">';
while($t<=15){
	if ($article[$t]){
		arrange_article($article[$t]);
		$t=$t+1;
	}
	else{
		$t=31;
	}
}
echo '</div>';
?>
<script>
$('.article_cluetip').cluetip({attribute: 'load', cluetipClass: 'rounded',tracking: false,sticky: true,mouseOutClose: true});
</script>