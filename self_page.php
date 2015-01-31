<?php
$user_id=$_SESSION['id'];
$box=check_if_user_has_display_box($user_id);
if ($box==true){
	$display_box=check_box_for_this_user_id($user_id);
	//echo $display_box[box_id];?>
	<div id="display_box"><div id="box_name"><?php
	echo $display_box[box_name];?>
	</div><div id="box_description"><?php
	echo $display_box[box_description];?>
	</div></div><?php
}
if ($box==false){
	
?>

<form action="create_display_box.php" method="post" >
	<textarea id="box_title" name="box_title">Title</textarea></br>
	<textarea id="box_description" name="box_description">Description</textarea></br>
	<input id="create_display_box" type="submit" value="Create Display Box"/>
</form>

<?php
}



?>