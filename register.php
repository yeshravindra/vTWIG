<style>
		#r_fail{ position:absolute; top:500px; left:650px; color:white;}
</style>

<?php
	include "core/init.php";
	include 'login_or_register.php';
	
		
	
	$username = $_POST['user_name'];
	$password = $_POST['password'];
	$first = $_POST['first'];
	$last = $_POST['last'];
	$mail = $_POST['mail']; 
	
	sanitize_register();
	echo '<div id="r_fail">';
	if (empty($username) === true || empty($password) === true || empty($first) === true || empty($last) === true || empty($mail) === true) {
	echo "You need to enter all fields!<br />";
		die();
	}
	
	if (preg_match("/\\s/",$username)||preg_match("/\\s/",$password)||preg_match("/\\s/",$first)||preg_match("/\\s/",$last)||preg_match("/\\s/",$mail) == true){
		echo "Your Username, Password, First Name, Last Name and Email should not contain any space<br/>";
		die();
	}
	
	if (user_exists($username) === true){	
		echo "username $username already exists!<br/>";
		//create_profile($first); test here
		echo "<br /><a href='http://localhost/vTwig/index.php'>Click here to login!</a><br />";
		die();
	}
	
	if (strlen($password)<6){
		echo "Your password must atleast be 6 characters!<br/>";	
		die();
	}
	
	if (filter_var($mail, FILTER_VALIDATE_EMAIL) === false){
		echo "Not a valid Email address!<br/>";
		die();
	
	}
	if (email_exists($mail) === true) {
			echo "Email you entered is already registered, please login or register with a diffrent id<br/>";
		die();
	}
	
	else {
		$password=md5($password);
		//$id=int($id);
		$register="INSERT into table2 (username,password,first_name,second_name,email)values('".$username."','".$password."','".$first."','".$last."','".$mail."')";
		//echo $register;
		$registered=mysql_query($register);
		if($registered){
					create_profile($username);
					$_SESSION['id']=mysql_insert_id();
					$next_url=$_GET['n'];
					if ((empty($next_url))AND(!isset($next_url))){
					header ('Location: home.php');
					die();
					}
					else{
						header ('Location:'.$next_url);
						//header('Location:display_box.php?user='.$user_data['username']);
					die();
					}
				
				}
		else{
				echo "Failed to register!";
		}
		
	}
echo '</div>';
?>