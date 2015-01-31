<?php
include 'core/init.php';
protect_page();
$q=(int)$_GET['q'];
if ($q==1){
//include "widgets/header.php";
	$tieup_user_id=$_POST['tie_up'];
	$tieup_user_id=(int)$tieup_user_id;
	
	$tie_status=check_tie_up($user_data['id'],$tieup_user_id);
	if($tie_status==true){
		header('Location:display_box.php?user='.$username);
	}
	if($tie_status==false){
	$row['ties']=get_current_ties($user_data['id']);
	$new_tie=$row['ties'].",".$tieup_user_id;
	$select1="UPDATE table2 SET table2.ties='".$new_tie."' WHERE table2.id='".$user_data['id']."'";
	$query_final1=mysql_query($select1);
	/*
	$row['ties']=get_current_ties($tieup_user_id);
	$new_tie=$row['ties'].",".$user_data['id'];
	$select2="UPDATE table2 SET table2.ties='".$new_tie."' WHERE table2.id='".$tieup_user_id."'";
	$query_final2=mysql_query($select2);*/
		$username=username_from_id($user_data['id']);
		header('Location:display_box.php?user='.$username);
	}
}

if ($q==2){
	//echo $row['ties']=get_current_ties($user_data['id']);
}
?>