<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($user_data_else['username']); ?></title>
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
			<a href="logout.php"><p>Logout</p></a>';
			}
		else {
				echo '<a href="index.php"><p>Home</p></a>
				<a href="login_or_register.php"><p>Publish</p></a>
				<a href="login_or_register.php"><p>LogIn</p></a>';				
			}
	?>
	</div>
	<div id="search_box">
		<form action="display_search_stuff.php" method="post">
		<input name="search_stuff" type="text" class="autosuggest">
		<input id="search_button" type="image" src="templates/media/search.gif" alt="Search"/>
		
		<div class="dropdown">
			<ul class="result">
			</ul>
		</div>
		</form>
		<script type="text/javascript" src="js/javascript.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<script type="text/javascript" src="js/home.js"></script>
		<script type="text/javascript" src="js/jquery.cluetip.min.js"></script>
	</div>
	<div id="t_dispbox">
	<div id="user_pic_else">		 
				<?php
				$user_pict='user_profiles/'.$user_data_else['username'].'/profilepic.jpg';
				if (!(file_exists($user_pict))){
					$user_pict='user_profiles/default/profilepic.jpg';
				}
				echo '<img src="'.$user_pict.'" width="120" height="140" alt="No pic found">';
				?>				
	</div> 

		
	
		