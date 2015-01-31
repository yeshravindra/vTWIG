<?php
if(isset($_GET['n'])){
	$next_url=$_GET['n'];
	$login_action='login.php?n='.$next_url;
	}
else {
	$login_action='login.php';
}

?>

<html>
<head>
<title>vTWIG</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="js/javascript.js"></script>
<link rel="stylesheet" href="login_or_signup.css">
</head>
<body>
		
		<div id="log_marg">
		<div id="top_bar"><a href="index.php" id="logo"></a></div>
						<div id="field_box">
							<h1>Login</h1>						
							<div id="login_form"> 
								<form action="<?php echo $login_action;?>" method="post">							
						<input type="text" name="user_name" class="text_box" placeholder="User Name or Email"><br/>					
						<input type="password" name="password" class="text_box" placeholder="Password"> <br/><br/>
										<input type="submit" value="Log in" class="button_"/>			
								</form>
							</div>
						
						
						
							<h1>Sign Up!</h1>
							<div id="register_form">
								<form action="register.php" method="post">
									<input type="text" name="user_name" class="text_box" placeholder="User Name"> <br />
									<input type="password" name="password" class="text_box" placeholder="Password"> <br />
									<input type="text" name="first" class="text_box" placeholder="First Name"> <br />
									<input type="text" name="last" class="text_box" placeholder="Last Name"> <br />
									 <input type="text" name="mail" class="text_box" placeholder="Email"> <br />
									<br /><input type="submit" value="Register"class="button_"/>
								</form>
							
							</div>
						</div>
			<img src="templates/media/vtwig_cover2.jpg" id="vtwig_cover"/>
			<div id="theme">read,share,learn</div>	
			<div id="footer">Yeshwanth Ravindra production</div>
		</div>
</body>
<script>
function move_log_marg(){
	window_width=$(window).width();
	object_width=$('#log_marg').width();
	$('#log_marg').css('left',(window_width/2)-(object_width/2));
};
move_log_marg();
</script>