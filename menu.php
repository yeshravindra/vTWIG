<div id="second_bar"><h3>Feeds</h3></div>
<div id="fourth_block"></div>
<div id="loading">Loading...<img src="templates/media/328.gif"/>
 <?php if ($browser=='ie'){echo 'Try Chrome, Mozilla or Safari to experience <br/> this website faster...';} ?> </div>
<div id="profile_align" >

<?php
	$feature=(int)$_GET['feature'];
	if (!empty($feature)AND(isset($feature))){
		include 'widgets/feature_page.php';
		}	
	else{
		include 'widgets/middle_box.php';
	}
?>
</div>

<div id="people_updates" >
<a href=""><h2>People</h2></a>
<?php	
	if (empty($_POST['publish'])===true) {
	
	}
	else{
	$publisher = htmlentities(mysql_real_escape_string($_POST['publish']));
	$publishing="INSERT INTO publish (text,timestamp,id)VALUES('".$publisher."',NOW(),'".$_SESSION['id']."')";
	$published=mysql_query($publishing);
	$publish_id=mysql_insert_id();
	}?>
	<form id="cover_line" action="" method="post">
		<textarea name="publish" placeholder="Publish something to the world.."></textarea>
		<input type="submit" value="Publish"/>
	</form>
	<?php
	$publish_id='127';
	get_complete_publish($publish_id);
?>
<div id="people_updates_article"></div>
</div>	
	
</div>
	
	
	
	