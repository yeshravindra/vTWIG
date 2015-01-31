<?php
	function check_current_publish_voters($publish_id){
		$select="SELECT publish.voter_ids FROM publish WHERE publish.publish_id='".$publish_id."'";
		$query_publish_voters=mysql_query($select);
		
		while (($row=mysql_fetch_assoc($query_publish_voters))!==false) {
	$current_voters=$row['voter_ids'];
	}
	return $current_voters;
	}

	function check_vote_for_publish($user_id,$publish_id){
		$current_voters=check_current_publish_voters($publish_id);
	$list_voters=explode(',', $current_voters);
	foreach($list_voters as $voter){
		if($voter==$user_id){
			return 1;
			die();
			exit();
		}
		else {
			
			}
		}
		return 0;
	
	}
	
	function count_vote_for_publish($publish_id){
		$count_voters=-1;
		$current_voters=check_current_publish_voters($publish_id);
		$list_voters=explode(',', $current_voters);	
		foreach($list_voters as $voter){
			$count_voters=$count_voters+1;
		}
		return $count_voters;
	}
	
	
	
	/**** Article func****/
	
	function check_current_article_voters($article_id){
		$select="SELECT article.voter_ids FROM article WHERE article.article_id='".$article_id."'";
		$query_article_voters=mysql_query($select);
		
		while (($row=mysql_fetch_assoc($query_article_voters))!==false) {
	$current_voters=$row['voter_ids'];
	}
	return $current_voters;
	}

	function check_vote_for_article($user_id,$article_id){
		$current_voters=check_current_article_voters($article_id);
	$list_voters=explode(',', $current_voters);
	foreach($list_voters as $voter){
		if($voter==$user_id){
			return 1;
			die();
			exit();
		}
		else {
			
			}
		}
		return 0;
	
	}
	
	function count_vote_for_article($article_id){
		$count_voters=-1;
		$current_voters=check_current_article_voters($article_id);
		$list_voters=explode(',', $current_voters);	
		foreach($list_voters as $voter){
			$count_voters=$count_voters+1;
		}
		return $count_voters;
	}
	
	
	
	
	
?>