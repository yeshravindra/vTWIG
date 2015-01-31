<?php
include 'core/init.php';
protect_page();
include "widgets/header.php";
$category=htmlentities(mysql_real_escape_string($_GET['category']));
$article_name=htmlentities(mysql_real_escape_string($_POST['article_name']));
$article_description=htmlentities(mysql_real_escape_string($_POST['article_description']));
$article_tagging=htmlentities(mysql_real_escape_string($_POST['article_tagging']));
$article_subdiv=htmlentities(mysql_real_escape_string($_POST['subdiv']));
$article_copy=(int)($_POST['copy']);

if (!empty($article_name) AND !empty($article_description) AND !empty($article_tagging) AND !empty($article_subdiv)){
$article_id=add_article_to_this_subdiv($article_subdiv,$article_name,$article_description,$article_tagging,$article_copy);
?>
		<div id="article_cover_page_upload">
			<form id="art_cover_choose" action="article_cover_page.php?article_number=<?php echo $article_id;?>" method="POST" enctype="multipart/form-data">
				<input type="file" name="file"></br>
				<input type="submit" value="Change cover picture">
					
			</form>
		</div>
	<div class="article_display"></br><?php
echo "successfully saved.";
echo "Choose a cover page";
echo '</div>';
}
else {
	check_if_category_exists($category);
?>	
	
	<form id="article_form" action="" method="POST">
			All fields are mandatory.</br>
<textarea id="article_name" type="text" class="input_signup" placeholder="ARTICLE NAME" name="article_name" maxlength="100" style="width: 700px; margin-bottom: 5px;"></textarea></br>
<textarea id="article_description" type="text" class="text_700" placeholder="ARTICLE DESCRIPTION, you may add more pages and contents later" name="article_description" maxlength="700" style="width: 700px; height:200px; margin-bottom: 5px;"></textarea></br>
<div id="char_left"></div></br>
<textarea id="article_tag" type="text" class="input_signup" placeholder="TAGS,Separated by comma" name="article_tagging" maxlength="640" style="width: 700px; height:40px; margin-bottom: 5px;"></textarea></br>
			<?php 	get_drop_down_all_subdiv();?>
			Please take a moment to read Copyright rules to avoid loss of contents and time.
			<select id="copyright" name="copy" style="width:700px;height:30px;font:bold 16px calibri; background:black;color:white;">
			<option value="0" title="Contents are open, can be reused,improved, developed but not duplicated. Users and algorithm filters out the duplicated data which reduces the reputation and the article may never showup in listing if found duplicate. Nevertheless, any PART of article can be developed or improved by others.">Standard vTWIG Licensing</option>
			<option value="1" title="Contents are not protected and may be removed upon Copyright claim. Cannot be used commercially unless approved by Owner">Reused from other sources, owner reserves rights</option>
			<option value="2" title="Content may be reused and developed for all commercial and non commercial purposes within vTWIG.com">Self generated content, Open source</option>
			<option value="3" title="Contents are reserved,others can use this for reference only. Author may claim Copyrights if used without permit.">Self generated content, All rights reserved</option>
			</select><br/><br/>
			<input id="j_go" type="submit" value="Create and continue"/><br/><br/><br/><br/><br/><br/>
			
</form>
	
<?php
}
?>
<script>
 var max_char700 = 700;
 $('#char_left').html(max_char700 +' characters remaining');
 
 $('.text_700').keyup(function(){
	var text_length=$('.text_700').val().length;
	var text_remaining= max_char700 - text_length;
 $('#char_left').html(text_remaining +' characters remaining');
	if ((text_remaining <= 20)&&(text_remaining >= 13)){
		$('.text_700').css('background','#f0d6d6');
		}
	else if ((text_remaining <= 12)&&(text_remaining >= 3)){
		$('.text_700').css('background','#ee8181');
		}
	else if (text_remaining <= 2){
		$('.text_700').css('background','#f03131');
	}
 else {
 $('.text_700').css('background','white');
 }
 });
</script>