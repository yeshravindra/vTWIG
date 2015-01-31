<style>
		#l_fail{ position:absolute; top:240px; left:650px; color:white;}
</style>

<?php
include 'core/init.php';
include 'login_or_register.php';

/*if (user_exists('yeshwanth') === true) {
	echo 'exists';
	die();
}*/
if (empty($_POST) === false) {
	$username = htmlentities($_POST['user_name']);
	$password = htmlentities($_POST['password']);
	$next_url=$_GET['n'];
	
	echo '<div id="l_fail">';
	if (empty($username) === true || empty($password) === true) {
		echo 'You need to enter Username and Password';
		} 
		else if ((user_exists($username) === false) AND (email_exists($username) === false)) {
			echo 'Username doesnot exist please register';
		}
		/*else if (user_active($username) === false) {
				$errors[] = 'Your account is not activated yet';
		}*/
		else if ((user_exists($username) === true) OR (email_exists($username) === true)){
				$login = login($username, $password);
				if ($login === false) {
					echo 'Username and Password combination is incorrect';
				}
				else {
					$_SESSION['id']=$login;
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
				
			}
				
		
		
		echo '</div>';
			
			
		
	}
?>