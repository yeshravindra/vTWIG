<?php
include 'core/init.php';
//protect_page();
include "widgets/header.php";

if (isset($_GET['s']) == true && empty($_GET['s']) == false){
	$search_stuff=htmlentities(mysql_real_escape_string($_GET['s']));
	$select="SELECT table2.id FROM table2 WHERE CONCAT( table2.first_name,  ' ', table2.second_name ) LIKE '$search_stuff%'";
	$query=mysql_query($select);
	?><div id="matching_results"><?php
	
	$select_count="SELECT COUNT(table2.id) AS search_count FROM table2 WHERE CONCAT( table2.first_name,  ' ', table2.second_name ) LIKE '$search_stuff%'";
	$query_count=mysql_query($select_count);
	
	while (($row=mysql_fetch_assoc($query_count))!==false) {
	$matches_found=$row['search_count']; echo '</br>';
	echo "<h3>Your search for <strong>'".$search_stuff."'</strong> resulted in <strong>'".$matches_found."'</strong> matches</h3>";
	}
	
	while (($row=mysql_fetch_assoc($query))!==false) {
	echo'</br>';
	echo $row['id'];
	}
	
	
}
?></div>