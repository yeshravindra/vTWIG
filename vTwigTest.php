<?php
$g=htmlentities('yes.ravindra@gmail.com');

if (filter_var($g, FILTER_VALIDATE_EMAIL) === true){
		echo "True<br/>";
		die();
	
	}
if (filter_var($g, FILTER_VALIDATE_EMAIL) === false){
		echo "False<br/>";
		die();
	
	}
else {
	echo 'Not ok';
}
?>