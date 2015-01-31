<?php 
	$connect_error = "Connection problem";
	$c=mysql_connect('localhost','','') or die($connect_error);
	mysql_select_db('vtwigcom_database1',$c);
?>