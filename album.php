<?php
	function album_data($album_id){
	//$album_data = array();
	$album_id = (int)$album_id;
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	if ($func_num_args > 1) {
		unset ($func_get_args[0]);
		$album_fields = '`'.implode('`,`', $func_get_args).'`';
		//echo $fields;
		//die();
		$album_data=mysql_fetch_assoc(mysql_query("SELECT $album_fields FROM album WHERE album_id=$album_id AND id=".$_SESSION['id']));
		return $album_data;
	}}
	
	function album_check($album_id){
		$album_id=(int)$album_id;
		$query = mysql_query("SELECT COUNT('album_id') FROM album WHERE album_id=$album_id AND id=".$_SESSION['id']."");
		return (mysql_result($query,0)==1) ? true : false;
	}
	
	function get_album(){
		$albums = array();
		
		$albums_query = mysql_query("SELECT `album`.`album_id`,`album`.`timestamp`,`album`.`name`, LEFT(`album`.`description`,50) as `description`, COUNT(`images`.`image_id`) as `image_count`
		FROM `album` LEFT JOIN `images` ON `album`.`album_id`=`images`.`album_id`
		WHERE `album`.`id` = ".$_SESSION['id']." GROUP BY `album`.`album_id`
		");
		while ($albums_row = mysql_fetch_assoc($albums_query)){
		$albums[]=array(
			'id'=>$albums_row['album_id'],
			'timestamp'=>$albums_row['timestamp'],
			'name'=>$albums_row['name'],
			'description'=>$albums_row['description'],
			'count'=>$albums_row['image_count']);			
	}
		return $albums;
	}
	
	
	function create_album($album_name, $album_description) {
		$album_name = mysql_real_escape_string(htmlentities($album_name));
		$album_description = mysql_real_escape_string(htmlentities($album_description));	
		mysql_query("INSERT into album (id,timestamp,name,description)values('".$_SESSION['id']."',UNIX_TIMESTAMP(),'".$album_name."','".$album_description."')");
		mkdir ("uploads/".mysql_insert_id(),0744);
		mkdir ("uploads/thumbs/".mysql_insert_id(),0744);
	}
	
	function edit_album($album_id,$album_name,$album_description){
		$album_id = (int)$album_id;
		$album_name= mysql_real_escape_string($album_name);
		$album_description= mysql_real_escape_string($album_description);
		
		mysql_query("UPDATE `album` SET `name`='$album_name',`description`='$album_description' WHERE `album_id`='$album_id' AND `id`=".$_SESSION['id']."");
		
	}
	
	function delete_album($album_id){
		$album_id=(int)$album_id;
		mysql_query("DELETE FROM `album` WHERE `album_id`=$album_id AND `id`=".$_SESSION['id']."");
		mysql_query("DELETE FROM `images` WHERE `album_id`=$album_id AND `id`=".$_SESSION['id']."");
	}
?>