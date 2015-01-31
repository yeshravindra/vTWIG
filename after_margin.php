		<?php if (logged_in()==true) { ?>
		<div id="pic"> 
				<?php
				$user_pict='user_profiles/'.$user_data['username'].'/profilepic.jpg';
				if (!(file_exists($user_pict))){
					$user_pict='user_profiles/default/profilepic.jpg';
				}
				
		echo '<a href="upload.php"><img src="'.$user_pict.'" width="120" height="140" alt="No pic found">';
				?>
		</div> 
		
		<div id="pic_upload">
			<p>Change profile pic</p>
		</div></a>
	
		<div id="username">
			<h2> <?php echo $user_data['first_name']; echo " ".$user_data['second_name']?></h2>
		</div>
		
		<?php } ?>		
		
	<div id="category_a1z">
	<li class="category_tab"><a href="#" id="t_adventure">Adventure</a></li>
	<li class="category_tab"><a href="#" id="t_art">Art</a></li>
	<li class="category_tab"><a href="#" id="t_educational">Educational</a></li>
	<li class="category_tab"><a href="#" id="t_entertainment">Entertainment</a></li>
	<li class="category_tab"><a href="#" id="t_howto">How To</a></li>
	<li class="category_tab"><a href="#" id="t_other">Other</a></li>
	<li class="category_tab"><a href="#" id="t_science">Science & Tech</a></li>	
	<li class="category_tab"><a href="#" id="t_sports">Sports</a></li>
	<li class="category_tab"><a href="#" id="t_stories">Stories</a></li>
	
	</div>
	
	