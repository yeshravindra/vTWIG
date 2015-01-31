<?php
include "core/init.php";
include 'widgets/header.php';
protect_page();
$q=(int)$_GET['q'];
$box_title=$_POST['box_title'];
$box_description=$_POST['box_description'];
$box_title=htmlentities(mysql_real_escape_string($box_title));
$box_description=htmlentities(mysql_real_escape_string($box_description));
if ((empty($box_title) AND empty($box_description))==false){

$select="SELECT COUNT(display_box.box_name) FROM display_box WHERE display_box.box_name='$box_title'";
	$box_ex=(mysql_result(mysql_query($select),0)==1)? true:false;

	if ($box_ex==true){
		echo '<h3>That box name is already taken. Please choose another.</h3>';
		echo '<form action="create_display_box.php?q=1" method="post" >
			<textarea id="box_title" name="box_title">Title</textarea></br>
			<textarea id="box_description" name="box_description">Description</textarea></br>
			<input id="create_display_box" type="submit" value="Create Display Box"/>
			</form>';
		die();
	}


$insert="INSERT INTO display_box(display_box.box_name,display_box.box_description,display_box.owner_id)VALUES('$box_title','$box_description','".$_SESSION['id']."')";
$query=mysql_query($insert);
if ($query){
header('Location:display_box.php?user='.$user_data['username']);
die();
}
}
$box=check_if_user_has_display_box($_SESSION['id']);
if($q==1){

if ($box==false){
echo '<form action="create_display_box.php?q=1" method="post" >
	<textarea id="box_title" name="box_title">Title</textarea></br>
	<textarea id="box_description" name="box_description">Description</textarea></br>
	<input id="create_display_box" type="submit" value="Create Display Box"/>
</form>';
}
else {
	header('Location:display_box.php?user='.$user_data['username']);
	die();
}
}

$e_box_title=$_POST['e_box_title'];
$e_box_description=$_POST['e_box_description'];
$e_box_title=htmlentities(mysql_real_escape_string($e_box_title));
$e_box_description=htmlentities(mysql_real_escape_string($e_box_description));
if ((empty($e_box_title) AND empty($e_box_description))==false){
	$box_ex=check_if_box_is_taken($e_box_title);
	if ($box_ex==true){
		echo '<h3>That box name is already taken. Please choose another.</h3>';
		echo '<form action="create_display_box.php" method="post" >
		<textarea id="box_title" name="e_box_title">'.$box_det['box_name'].'</textarea></br>
		<textarea id="box_description" name="e_box_description">'.$box_det['box_description'].'</textarea></br>
		<input id="create_display_box" type="submit" value="Edit Your Box"/>
		</form>';
		die();
	}
$update="UPDATE display_box SET display_box.box_name='$e_box_title',display_box.box_description='$e_box_description' WHERE display_box.owner_id='".$_SESSION['id']."'";
$update_query=mysql_query($update);
if ($update_query){
header('Location:display_box.php?user='.$user_data['username']);
die();
}
else {
	echo 'an error occured try again!';
	$box_det=check_box_for_this_user_id($_SESSION['id']);
	echo '<form action="create_display_box.php" method="post" >
	<textarea id="box_title" name="e_box_title">'.$box_det['box_name'].'</textarea></br>
	<textarea id="box_description" name="e_box_description">'.$box_det['box_description'].'</textarea></br>
	<input id="create_display_box" type="submit" value="Edit Your Box"/>
	</form>';
}
}

if($q==2){
if ($box==true){
	$box_det=check_box_for_this_user_id($_SESSION['id']);
	echo '<form action="create_display_box.php" method="post" >
	<textarea id="box_title" name="e_box_title">'.$box_det['box_name'].'</textarea></br>
	<textarea id="box_description" name="e_box_description">'.$box_det['box_description'].'</textarea></br>
	<input id="create_display_box" type="submit" value="Edit Your Box"/>
	</form>';
}
}


else{
	//header('Location:display_box.php?user='.$user_data['username']);
}
?>