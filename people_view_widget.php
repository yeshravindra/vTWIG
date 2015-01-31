<div id="people_tie_up">
<?php
	
	if ($user_data_else['id']==$_SESSION['id']){
			$edit=true;
		}
	if ($edit==false){
	$tie_up=check_tie_up($user_data['id'],$user_data_else['id']);
	if ($tie_up==true){
		echo '<br/><div id="bookmark_done">Bookmarked</div>';
	}
	
	if ($tie_up==false){
	
	if (logged_in()==true){ $action='tie_up.php?q=1'; }
	else { 
	$next_url='display_box.php?user='.$user_data_else['username'];
	$action='login_or_register.php?n='.$next_url; }

		?>		
		<form action="<?php echo $action;?>" method="post" >
			<input type="hidden" name="tie_up" value="<?php echo $user_data_else['id'];?>">
			<input id="bookmark" type="submit" value="Bookmark"/>
		</form>
		<?php
	}
	}
	
echo '</div><br/>';?>

<div id="username_else"><?php 
			$box=check_if_user_has_display_box($user_data_else['id']);
			if ($box == true){
				$display_box=check_box_for_this_user_id($user_id);
				$box_name=$display_box[box_name];
			}
			else {
				$box_name=$user_data_else['username'];
			}
			echo '<h2>'.$box_name.'</h2>';
			echo '<h3>'.$user_data_else['first_name'].' '.$user_data_else['second_name'].'</h3>';?>
</div>

<?php
echo '<div id="display_box_about_panel">';
		echo '<div id="box_description">';
		echo $display_box[box_description];
		echo '</div>';			
echo '</div>';

echo '<div id="display_box_list">';
			$article_all=get_articles_for_this_user($user_data_else['id']);
			if (!empty($article_all)){
			foreach ($article_all as $article){
				echo '<div id="home_article_list">';
						arrange_article($article[article_id]);
				echo '</div>';
			}		
			}
			else {
				echo '<h4>No articles in this display box yet!</h4>';
			}
echo '</div>';

if($edit==true){
	$user_id=$_SESSION['id'];
	$box=check_if_user_has_display_box($user_id);
	if ($box==true){
		
		echo '<div id="display_edit"><a href="create_display_box.php?q=2">edit</a></div>';
	}
	else{
		echo '<div id="display_edit"><a href="create_display_box.php?q=1">You do not have a display box configured. Create now</a></div>';
	}
}

?>
</div>