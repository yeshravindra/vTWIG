<?php
	function publish(){
	$published=array();
	$show="SELECT `publish`.`text`,`publish`.`id`,`publish`.`timestamp`,`publish`.`publish_id` FROM `publish`ORDER BY `publish`.`timestamp`DESC LIMIT 0,30";
	$shown=mysql_query($show);
	while($show_all = mysql_fetch_assoc($shown)){
		$publish_all[]=$show_all;	
	}
	return($publish_all);
}
	
	function get_publish_data($publish_id){
	$publish_id=(int)$publish_id;
	$publish=array();
	$publish_query=mysql_query("SELECT publish.publish_id, publish.text, publish.timestamp, publish.id FROM publish WHERE publish.publish_id=".$publish_id);
	$publish = mysql_fetch_assoc($publish_query);
	 return $publish;
}

	

	function view_annotate($publish_id){
		$publish_id=(int)$publish_id;
		$view_annotates=array();
		$select="SELECT annotate.ann_id, annotate.ann_text,annotate.id,annotate.`timestamp` FROM annotate WHERE annotate.publish_id='".$publish_id."' ORDER BY annotate.`timestamp` LIMIT 3";
		$query=mysql_query($select);
		//$view_annotates=$query;
		while($view_annotates=mysql_fetch_assoc($query)){
			$view_all_annotates[]=$view_annotates;
		}
		return($view_all_annotates);
	}
	
	function annotate_count($publish_id){
	$publish_id=(int)$publish_id;
		$view_annotates=array();
		$select="SELECT COUNT(annotate.ann_id) FROM annotate WHERE annotate.publish_id='".$publish_id."'";
		$query=mysql_query($select);
		$annotates_count=mysql_result($query,0);
		return($annotates_count);
	}
	
	function get_complete_publish($publish_id){
		
		$published=get_publish_data($publish_id);
$published[counts]=annotate_count($publish_id);
?>
<div id="total_publish">
<div id="publish_box"><div id="publish_text"><?php
		echo '<h4><pre width="35px">'.$published['text'].'</pre></h4>';
		$user_id=$published['id'];
		?></div><div id="publisher_details_box_and_votes"><div id="publisher_name"><h4><?php
		$publisher=first_second_from_id($user_id);
		$publisher_username=username_from_id($user_id);
		
		$publisher_link="display_box.php?user=$publisher_username";
			echo '<a href='.$publisher_link.'>'.$publisher.'</a>';
		
		$thumb_pic="user_profiles/".$publisher_username."/thumb/profilepic.jpg";
		if (!(file_exists($thumb_pic))){
				$thumb_pic="user_profiles/default/thumb/profilepic.jpg";
			}
		?></div><div id="published_time"><?php echo getRelativeTime($published['timestamp']);?></div><div id="thumb_pic" ><?php echo '<img src="'.$thumb_pic.'"/>';
		$do_annotate="do_annotate.php?publish_id=".$published['publish_id']."&q=1";
		?></div><div id="comment_count"><?php echo $published[counts].'comments';?></div></h4><br/></div>
		
		
		<?php
		$publish_id=$published['publish_id'];
		$view_all_annotates=view_annotate($publish_id);
		/**************************************PUBLISH VOTE BEGINS****************************/
		$vote_enable=check_vote_for_publish($user_data['id'],$publish_id);
		$count_vote_for_publish=count_vote_for_publish($publish_id);
		if ($vote_enable==false){
								?>		
							<div id="votes_count">
								<?php		
							echo $count_vote_for_publish.' votes';
								?></div>
							<form action="votes.php" method="post" >
								<input type="hidden" name="votes_publish" value="<?php echo $publish_id;?>"/>
								<input id="vote_button" type="submit" value="Vote"/>
							</form><?php
			}
		
		else{			?>
							<div id="voting_done"><?php echo $count_vote_for_publish.' votes';
							?></div>					
						<?php	
		}
		/**************************************PUBLISH VOTE ENDS*****************************/
		?></div><div id="all_annotations"><?php
		foreach ($view_all_annotates as $view_annotate){
			echo "";?><br /><div id="view_annotations"><div id="annotation_text"><?php
			echo '<pre width="25px">'.$view_annotate['ann_text'].'</pre>';
			$annotator_id=$view_annotate['id'];?></div><br /><div id="annotator_box"><div id="annotator_name"><?php
			$annotator_first_second=first_second_from_id($annotator_id);
			$annotator_username=username_from_id($annotator_id);
			
			$annotator_link="display_box.php?user=$annotator_username";
			echo '<a href='.$annotator_link.'>'.$annotator_first_second.'</a><br/>';
			$thumb_pic="user_profiles/".$annotator_username."/thumb/profilepic.jpg";
			if (!(file_exists($thumb_pic))){
				$thumb_pic="user_profiles/default/thumb/profilepic.jpg";
			}
			?></div><div id="annotate_time"><?php echo getRelativeTime($view_annotate[timestamp]);?></div><div id="annotator_image"><?php
			echo '<img src="'.$thumb_pic.'"/>';
			?></div></div></div><?php
		}?></div>
		<form id="do_annotate" action="<?php echo $do_annotate;?>" method="post">
		<textarea name="annotate_text"></textarea>
		<input type="submit" value="annotate"/>
		</form></div><?php		
	}
	
	
	
?>