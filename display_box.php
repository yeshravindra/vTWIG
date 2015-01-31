<?php
include 'core/init.php';
//protect_page();
//include "widgets/header.php";


if (isset($_GET['user'])) {
		$username=$_GET['user'];
		$username=htmlentities(mysql_real_escape_string($username));
		if (($check=user_exists($username))==false){
			header('Location:display_box.php?user='.$user_data['username']);
			die();
		}
		$user_id=id_from_username($username);
		$user_data_else = user_data($user_id,'id','username','password','first_name','second_name','email');
		include "widgets/header_else.php";		
		include "widgets/people_view_widget.php";
		exit();
	}





?>

