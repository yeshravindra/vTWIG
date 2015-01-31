<?php
include 'core/init.php';

			
			$article_id=$_POST['votes_article'];
			if (!empty($article_id)){
			$select="SELECT article.voter_ids FROM article WHERE article.article_id='".$article_id."'";
			$select_query=mysql_query($select);
			$current_voters=array();
			while (($row=mysql_fetch_assoc($select_query))!==false) {
			$current_voters=$row['voter_ids'];
			}
			
			$new_vote=$current_voters.",".$user_data['id'];
			
			
			
			
			$insert="UPDATE article SET article.voter_ids=('".$new_vote."') WHERE article.article_id='".$article_id."'";
			$update_query=mysql_query($insert);
			header('Location:view_article.php?article='.$article_id);
			}

?>