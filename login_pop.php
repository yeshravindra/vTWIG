<style>
#ymurtu{width: 200px; margin: 5px;}
#poilku{width: 200px; margin: 5px;}
#hjdusk{margin: 5px;font:13px arial; font-weight:bold; border:-1px solid white;
	background:-webkit-linear-gradient(top,#627ba7,#000000) no-repeat;
	background:-moz-linear-gradient(top,#627ba7,#000000) no-repeat;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#627ba7', endColorstr='#000000');
	
	height:30px; width:90px; color:white; margin-top:-10px;}
#hjdusk:hover{cursor:pointer}
#huewqu{ position:relative; color:white; top:-45px; left:110px;}
#yrtydh{ position:relative; color:white; width:3px; height:3px; top:-65px; left:180px;}
#yrtydh:hover{cursor:pointer;}
</style>

<form action="login.php" method="post">			
<input id="ymurtu" type="text" name="user_name" placeholder="User Name or Email"><br>			
<input id="poilku" type="password" name="password" placeholder="Password"><br><br>
<input id="hjdusk" type="submit" value="Log In">			
</form>
<a href="login_or_register.php" id="huewqu">Register</a>
<div id="yrtydh" title="Close">[x]</div>

<script>
$('#yrtydh').click(function(data){
	$('#login_pop2').hide();
	$('#login_pop1').hide();
});
</script>