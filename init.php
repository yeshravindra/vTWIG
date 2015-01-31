<?php
session_start();
error_reporting(0);
require "database/db.php";
require "functions/general.php";
require "functions/users.php";
require "functions/album.php";
require "functions/image.php";
require "functions/thumb.php";
require "functions/publish.php";
require "functions/voter_func.php";
require "functions/category_func.php";
require "functions/groups_func.php";
require "functions/display_box_func.php";


if (logged_in() === true) {
	$session_user_id = $_SESSION['id'];
	$user_data = user_data($session_user_id,'id','username','password','first_name','second_name','email');
}

?>