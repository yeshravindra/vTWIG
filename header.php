<!DOCTYPE html>
<html>
	<head>
		<?php 
		if (logged_in()==true){ 
			echo '<title>'.$user_data['username'].'</title>';
		}
		else {
			echo '<title>vtwig</title>';
		}
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<?php
			$browser = get_browser(null, true);
			$browser=strtolower($browser['browser']);
			if (logged_in()==true){ $style='stylesheets';$style2='stylesheets_guest';}
			else { $style='stylesheets_guest';}
			
			if (($browser=="chrome")OR($browser=="firefox")OR($browser=="safari")){
				$browser1=1;
				echo '<link rel="stylesheet" href="templates/'.$style.'/chrome.css">';
				echo '<link rel="stylesheet" href="templates/'.$style2.'/chrome.css">';
			}
			
			if ($browser=="ie"){
				$browser1=1;
				echo '<link rel="stylesheet" href="templates/'.$style.'/ie.css">';
				echo '<link rel="stylesheet" href="templates/'.$style2.'/ie.css">';
			}
			
			if ($browser == "opera"){
				$browser1=1;
				echo '<link rel="stylesheet" href="templates/'.$style.'/opera.css">';				
				echo '<link rel="stylesheet" href="templates/'.$style2.'/opera.css">';				
			}
			
			if ((!isset($browser1))AND(empty($browser1))){
				echo '<link rel="stylesheet" href="templates/'.$style.'/misc.css">';
				echo '<link rel="stylesheet" href="templates/'.$style2.'/misc.css">';
			}
		?>
		<link rel="icon" href="templates/stylesheets_guest/favicon.ico">
	</head>
	<body>
	<div id="top_bar">
	
	<a href="index.php" id="logo"><img src="templates/stylesheets_guest/beta.gif" id="beta" /></a>
	</div>
	<div id="option1">
	<?php if (logged_in()==true){
			
			echo '<a href="home.php"><p>Home</p></a>
			<a href="display_box.php?user='.$user_data['username'].'"><p>Publish</p></a>
			<a href="logout.php"><p>Logout</p></a>';
			}
		else {
				echo '<a href="index.php"><p>Home</p></a>
				<a href="login_or_register.php"><p id="t_publish">Publish</p></a>
				<a href="login_or_register.php"><p id="t_log2" >LogIn</p></a>';				
			}
	?>
	</div>
	<div id="search_box">
		<form action="display_search_stuff.php" method="GET">
		<input name="s" type="text" class="autosuggest">
		<input id="search_button" type="image" src="templates/media/search.gif" alt="Search"/>
		
		<div class="dropdown">
			<ul class="result">
			</ul>
		</div>
		</form>
		<script type="text/javascript" src="js/javascript.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<script type="text/javascript" src="js/home.js"></script>
	</div>
	<div id="margin_box">	