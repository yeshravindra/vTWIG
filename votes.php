<?php
include 'core/init.php';
protect_page();
	
			$publish_id=(int)$_POST['votes_publish'];
			if (!empty($publish_id)){
			$select="SELECT publish.voter_ids FROM publish WHERE publish.publish_id='".$publish_id."'";
			$select_query=mysql_query($select);
			$current_voters=array();
			while (($row=mysql_fetch_assoc($select_query))!==false) {
			$current_voters=$row['voter_ids'];
			}
			$new_vote=$current_voters.",".$user_data['id'];
				
				
			$insert="UPDATE publish SET publish.voter_ids=('".$new_vote."') WHERE publish.publish_id='".$publish_id."'";
			$update_query=mysql_query($insert);
			header('Location:home.php');
			}
			
			$article_id=(int)$_GET['vOTes_ArtICle'];
			if ((!empty($article_id))AND(isset($article_id))){
			$select="SELECT article.voter_ids FROM article WHERE article.article_id='".$article_id."'";
			$select_query=mysql_query($select);
			while (($row=mysql_fetch_assoc($select_query))!==false) {
				$current_voters=$row['voter_ids'];
			}
			
			$new_vote=$current_voters.",".$user_data['id'];
			print_r($new_vote);
			$insert="UPDATE article SET article.voter_ids=('".$new_vote."') WHERE article.article_id='".$article_id."'";
			$update_query=mysql_query($insert);
			}
				
			?>
