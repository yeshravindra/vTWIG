<?php
	include 'core/init.php';
	if (logged_in()==true){
		header('Location:home.php');
		exit();
	}
	include 'widgets/header.php';
	include 'widgets_guest/menu.php';
	include 'widgets/after_margin.php';
	include 'widgets/footer.php';
?>
</div>
<?php include 'top_scroll.php';
?>
<input type="button" id="s_h" value="hide" style="position:absolute; top:65px; left:50px; z-index:91;"/>

<script>
	$('#s_h').ready(function(){
		$('#margin_box').animate({ 'top': 240 },500);
	});

	$('#s_h').toggle(function(){
		$('#makeMeScrollable').slideUp(800);
		$('#s_h').val('show');
		$('#margin_box').animate({ 'top': 100 },800);
		},	function(){
		$('#makeMeScrollable').slideDown(800);
		$('#s_h').val('hide');
		$('#margin_box').animate({ 'top': 240 },800);
	});
	
</script>