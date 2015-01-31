<?php
error_reporting(0);
require 'database/db.php';
require 'functions/category_func.php';
$article_id=(int)$_GET['article'];
$page=(int)$_GET['page'];
$edit=(int)$_GET['yedz'];
echo '<div id="aj_page">';
if ($edit==true){
				$content=get_article_content_page_wise_to_edit($article_id);
			}
				else {
				$content=get_article_content_page_wise_to_view($article_id);
			}
echo '</div>';
?>
<style>
	#aj_page h2{font-family:Times New Roman,constania,Arial,Helvetica,sans-serif;color:#47577b;font-weight:200;font-size:22px;}
	#aj_page h4{font-family:Times New Roman,constania,Arial,Helvetica,sans-serif;color:#1a1a1a;font-weight:200;font-size:16.5px;word-spacing:3px;line-height:140%}
	#aj_e_p {font-family:Times New Roman,constania,Arial,Helvetica,sans-serif;color:#3838fa;font-weight:200;font-size:13px;}
</style>