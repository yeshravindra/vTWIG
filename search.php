<?php
include "core/init.php";
//protect_page();
$row=array();
if (isset($_POST['search_term']) == true && empty($_POST['search_term']) == false){
	$search_term=htmlentities(mysql_real_escape_string($_POST['search_term']));
	
	$query=mysql_query("SELECT CONCAT(table2.first_name,' ',table2.second_name)AS user FROM table2 WHERE CONCAT(table2.first_name,' ',table2.second_name) LIKE '$search_term%'");
	while (($row=mysql_fetch_assoc($query))!==false) {
	echo '<li>',$row['user'],'</li>';
	}
}
?>