<?php 
include "core/init.php";
if ($_GET['q']==1){
if(!isset($_POST['annotate_text'])||(empty($_POST['annotate_text'])) ){
header('Location:home.php');
die();
}
else{
$annotate_text=($_POST['annotate_text']);
$annotate_text=htmlentities(mysql_real_escape_string($annotate_text));
$publish_id = $_GET['publish_id'];
$insert="INSERT INTO annotate(annotate.ann_text, annotate.publish_id, annotate.id,annotate.timestamp)VALUES('".$annotate_text."','".$publish_id."','".$_SESSION['id']."',NOW())";
$query=mysql_query($insert);
header('Location:home.php');
die();
}
}

if ($_GET['q']==2){
$donot='Say something about this article..';
if(!isset($_POST['annotate_text_article'])||(empty($_POST['annotate_text_article']))||($_POST['annotate_text_article']==$donot)){
$article_id=$_GET['article_id'];
header('Location:view_article.php?article='.$article_id);
die();
}
else{
$annotate_text=($_POST['annotate_text_article']);
$annotate_text=htmlentities(mysql_real_escape_string($annotate_text));
$article_id = $_GET['article_id'];
$insert="INSERT INTO annotate_article(annotate_article.art_ann_text, annotate_article.article_id, annotate_article.id, annotate_article.art_ann_time)VALUES('".$annotate_text."','".$article_id."','".$_SESSION['id']."',NOW())";
$query=mysql_query($insert);
header('Location:view_article.php?article='.$article_id);
die();
}
}



?>