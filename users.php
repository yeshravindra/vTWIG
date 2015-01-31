<?php
function user_data($id) {
	$data = array();
	$id = (int)$id;
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	if ($func_num_args > 1) {
		unset ($func_get_args[0]);
		$fields = '`'.implode('`,`', $func_get_args).'`';
		//echo $fields;
		//die();
		$data=mysql_fetch_assoc(mysql_query("SELECT $fields FROM table2 WHERE id='$id'"));
		return $data;
				
	}
	
}


function logged_in(){
	 if (isset ($_SESSION['id'])){
		return true;
	 }
	 else {
		return false;
	 }

}

function user_exists($username) {
	$username = sanitize($username);
	return (mysql_result(mysql_query("SELECT COUNT(id) FROM table2 WHERE username='$username'"),0)==1) ? true : false;
}


function id_from_username($username){
	$username = sanitize ($username);
	return mysql_result(mysql_query("SELECT (id) FROM table2 WHERE username='$username'"),0,'id');
}
function id_from_email($mail){
	$username = sanitize ($mail);
	return mysql_result(mysql_query("SELECT (id) FROM table2 WHERE email='$mail'"),0,'id');
}

function login($username, $password) {
	$email=$username;
	$username_true = htmlentities(mysql_real_escape_string($username));
	$password = htmlentities(mysql_real_escape_string($password));
	$password = md5($password);
	//return (mysql_result(mysql_query("SELECT count(id) FROM table2 WHERE username='$username' and password='$password'"),0)==1) ? $id : false;
	$log_stat_usr=mysql_result(mysql_query("SELECT count(id) FROM table2 WHERE username='$username_true' and password='$password'"),0);
	if($log_stat_usr == 1){
		$id = id_from_username($username);
		$id = (int)($id);
		return $id;
	}
	else {
			if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
							return false;
					}
			else {
				$log_stat_ema=mysql_result(mysql_query("SELECT count(id) FROM table2 WHERE email='$email' and password='$password'"),0);
				if($log_stat_ema == 1){
				$id=id_from_email($email);
				$id = (int)($id);
				return $id;
				}
				else {
				return false;
				}
			}	
	}
}

function sanitize_register() {
	$username = sanitize($username);
	$password = sanitize($password);
	$first = sanitize($first);
	$last = sanitize($last);
	$mail = sanitize($mail);

}

function email_exists($mail) {
	$mail = sanitize($mail);
	return (mysql_result(mysql_query("SELECT COUNT(id) FROM table2 WHERE email='$mail'"),0)==1) ? true : false;	
	}


function create_profile($username) {
	mkdir ("user_profiles/".$username);
	mkdir ("user_profiles/".$username."/thumb");
}

function first_second_from_id($user_id){
	$user_id=(int)$user_id;
	//$select="SELECT table2.first_name FROM table2 WHERE table2.id=".$user_id;
	$select="SELECT CONCAT(table2.first_name,' ',table2.second_name)AS publisher FROM table2 WHERE table2.id=".$user_id;
	$query=mysql_query($select);
	$publisher=mysql_fetch_row($query);
	return $publisher[0];
}
function username_from_id($user_id){
	$user_id=(int)$user_id;
	//$select="SELECT table2.first_name FROM table2 WHERE table2.id=".$user_id;
	$select="SELECT table2.username FROM table2 WHERE table2.id=".$user_id;
	$query=mysql_query($select);
	$publisher_username=mysql_fetch_row($query);
	return $publisher_username[0];


}

function get_current_ties($user_id){
	$hdj46j="SELECT table2.ties FROM table2 WHERE table2.id='".$user_id."'";
	$query_ties=mysql_query($hdj46j);
		
	while (($row=mysql_fetch_assoc($query_ties))!==false) {
	$current_ties=$row['ties'];
	}
	return $current_ties;
}



function check_tie_up($user_requestor,$user_acceptor){
	$current_ties=get_current_ties($user_requestor);
	$list_ties=explode(',', $current_ties);
	foreach($list_ties as $list){
		if($list==$user_acceptor){
			return 1;
			die();
			exit();
		}
		else {
			
			}
		}
		return 0;
}





?>