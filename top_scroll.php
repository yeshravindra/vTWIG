<!DOCTYPE html>
<html>
<head>
	<link rel="Stylesheet" type="text/css" href="js/scroll/css/smoothDivScroll.css" />
	<style type="text/css">

		#makeMeScrollable
		{
			width:720px;
			height: 145px;
			position: absolute;
			overflow:hidden;
			top:75px;
			left:100px;
			background:black;
			z-index:89;
		}
		
	
		#makeMeScrollable div.scrollableArea img
		{
			position: relative;
			margin: 0;
			padding: 0;
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-o-user-select: none;
			user-select: none;
		}
		.spin{
			position:relative;
			display:inline-block;
		}
	</style>
	
</head>

<body>

	<div id="makeMeScrollable">
		
		<div id="t_1" class="spin"><?php arrange_article(1);?></div>
		<div id="t_2"class="spin"><?php arrange_article(138);?></div>
		<div id="t_3"class="spin"><?php arrange_article(2);?></div>
		<div id="t_4" class="spin"><?php arrange_article(142);?></div>
		<div id="t_5" class="spin"><?php arrange_article(146);?></div>
		<div id="t_6" class="spin"><?php arrange_article(160);?></div>
		<div id="t_7" class="spin"><?php arrange_article(152);?></div>
		<div id="t_8" class="spin"><?php arrange_article(145);?></div>
		<div id="t_9" class="spin"><?php arrange_article(154);?></div>	
		<div id="t_10" class="spin"><?php arrange_article(143);?></div>	
		
	</div>
	

	<script src="js/scroll/1scrl.js" type="text/javascript"></script>
	<script src="js/scroll/2scrl.js" type="text/javascript"></script>
	<script src="js/scroll/3scrl.js" type="text/javascript"></script>
	<script src="js/scroll/4scrl.js" type="text/javascript"></script>

	<script type="text/javascript">
	
		$(document).ready(function () {
			$("div#makeMeScrollable").smoothDivScroll({
				autoScrollingMode: "onStart"
			});
		});
	</script>

</body>
</html>