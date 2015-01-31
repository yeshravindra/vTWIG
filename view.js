$(document).ready(function(){
var lt= $('#view_panel').offset();
$('#full_screen').toggle(function(){		
		
		$('body > :not(#view_panel)').hide();
		$('#view_panel').appendTo('body');
		$('body').css('background','#444');
		$('#view_panel').css('left',($(window).width()/2)-($('#view_panel').width()/2)).css('top',($(window).height()/2)-($('#view_panel').height()/2));
		
		$('#full_screen').css('background-color', '#506488');
						
						$('#full_screen').mouseenter(function(){
						$('#full_screen').css('background-color', '#b8b9bc');
						});
						$('#full_screen').mouseleave(function(){
						$('#full_screen').css('background-color', '#506488');});
		},	function(){
		$('body > :not(#view_panel)').show();
		$('body').css("background-image", "url(templates/media/stripe2.gif)");
		$('#view_panel').css('position','absolute').css('left',lt.left).css('top',lt.top);
		$('#full_screen').css('background-color', '#b8b9bc');
						$('#full_screen').mouseenter(function(){
						$('#full_screen').css('background-color', '#506488');
						});
						$('#full_screen').mouseleave(function(){
						$('#full_screen').css('background-color', '#b8b9bc');});		
	});

$('#clear_cover').mouseenter(function(){
	$('#clear_cover').css("background-image","url(templates/media/clr2.gif)");
	$('#j_desc_art').stop().animate({ 'left': 750 },800);
	$('#j_title').stop().animate({ 'left': -500 },800);
	$('#j_page').stop().animate({ 'top': 500 },800);
});
$('#clear_cover').mouseleave(function(){
	$('#clear_cover').css("background-image","url(templates/media/clr1.gif)");
	$('#j_desc_art').stop().animate({ 'left': 500 },800);
	$('#j_title').stop().animate({ 'left': 10 },800);
	$('#j_page').stop().animate({ 'top': 30 },800);
});

$('#full_screen').mouseenter(function(){
						$('#full_screen').css('background-color', '#506488');
						});
$('#full_screen').mouseleave(function(){
						$('#full_screen').css('background-color', '#b8b9bc');
						});

function update_page(){
$('#loading_page').show().css('text-align','center');
$.get('aJ_l0Ad.php', { article:a, page:p, yedz:ezj },function (data){
	$('#loading_page').hide();
	$('#j_content').html(data);
});

if (p > 1){$('#j_prev').css('background-color','#506488');} else {$('#j_prev').css('background-color','#b8b9bc');}
if (p < (mp-1)){$('#j_next').css('background-color','#506488');} else {$('#j_next').css('background-color','#b8b9bc');}
};
var p=1;
$('#j_continue_reading').click(function(){
	$('#j_page').css('display','block');
	$('#j_desc_art').hide();
	$('#j_title').hide();
	p=1;
	update_page();
	//$('#j_image_scroll').tinyscrollbar();
	$('#j_continue_reading').hide();
	$('#j_prev').show();
	$('#j_next').show();
});
$('#j_prev').click(function(){
	p=p-1;
	if (p >=1){
	update_page();
	}
	else {
	p=1;
	}
});				
$('#j_next').click(function(){
	p++;
	if (p < mp){
	update_page();
	}
	else {
	p=mp;
	}
});
$('#j_continue_reading').mouseenter(function(){
						$('#j_continue_reading').css('background-color', '#506488');
						});
$('#j_continue_reading').mouseleave(function(){
						$('#j_continue_reading').css('background-color', '#f2c11e');
						});		

$('#j_select_page').change(function(){
	 var page=$('#j_select_page').val();
	 p=page;
	 if (p==0) {
		$('#j_page').hide();
		$('#j_continue_reading').show();
		$('#j_desc_art').show();
		$('#j_title').show();
		$('#j_prev').hide();
		$('#j_next').hide();
	 }
	 else{
		 $('#j_page').css('display','block');
		 update_page();
		 //$('#j_image_scroll').tinyscrollbar();
		 $('#j_continue_reading').hide();
		 $('#j_prev').show();
		 $('#j_next').show();
	 }
});

$('#j_vote1').click(function(){
	$('#j_and_other').show();
	$('#j_vote1').html('You');
	$('#j_vote1').animate({ 'left': 178 },800);
	$.get('votes.php', { vOTes_ArtICle:a });	
});
$('#j_vote2').toggle(function(){
	$('#j_talks').stop().animate({ 'top': 80 },800);
	$('#j_log_view').slideDown(800);
	},function(){
	$('#j_talks').stop().animate({ 'top': 40 },800);
	$('#j_log_view').slideUp(800);
});


});	