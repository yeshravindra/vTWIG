<?php
function protect_page() {
	if (logged_in() === false) {
	header('Location:not_found.php');
	exit();}
	
	}


function sanitize($data) {
	return mysql_real_escape_string($data);
}

function plural($num) {
    if ($num != 1)
    return "s";
    }
     
    function getRelativeTime($date) {
    $diff = time() - strtotime($date);
    if ($diff<60)
    return $diff . " second" . plural($diff) . " ago";
    $diff = round($diff/60);
    if ($diff<60)
    return $diff . " minute" . plural($diff) . " ago";
    $diff = round($diff/60);
    if ($diff<24)
    return $diff . " hour" . plural($diff) . " ago";
    $diff = round($diff/24);
    if ($diff<7)
    return $diff . " day" . plural($diff) . " ago";
    $diff = round($diff/7);
    if ($diff<4)
    return $diff . " week" . plural($diff) . " ago";
    return "on " . date("F j, Y", strtotime($date));
    }


	
?>