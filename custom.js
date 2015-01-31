$(document).ready(function(){
 
$('#t_adventure').click(function(){
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({
	url: 'category.php?category=adventure',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeOut(0);
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});

$('#t_art').click(function(){
	$('#profile_align').empty();
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({	
	url: 'category.php?category=art',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});

$('#t_educational').click(function(){
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({
	url: 'category.php?category=educational',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});

$('#t_entertainment').click(function(){
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({
	url: 'category.php?category=entertainment',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});
$('#t_howto').click(function(){
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({
	url: 'category.php?category=howto',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});


$('#t_other').click(function(){
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({
	url: 'category.php?category=other',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});

$('#t_science').click(function(){
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({
	url: 'category.php?category=science',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});

$('#t_sports').click(function(){
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({
	url: 'category.php?category=sports',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});

$('#t_stories').click(function(){
	$('#profile_align').hide();
	$('#loading').show();
	$.ajax({
	url: 'category.php?category=stories',
	success:function(data){
		$('#loading').hide();
		$('#profile_align').fadeIn(500);
		$('#profile_align').html(data);
	}	
	});
});


$(document).mousemove(function(){
	$.ajax({
		url:'people_feeds.php',
		success:function(data){
		$('#people_updates_article').html(data);
		}
	});
});

function move_div(){
	window_width=$(window).width();
	object_width=$('#top_bar').width();
	$('#top_bar').css('left',(window_width/2)-(object_width/2));
	$('#margin_box').css('left',(window_width/2)-(object_width/2)).css('height',($('#featured_artilces').height()+70));
	$('#t_dispbox').css('left',(window_width/2)-(object_width/2));	
	$('#search_box').css('left',(window_width/2)-(object_width/2)+250);
	$('#option1').css('left',(window_width/2)-(object_width/2)+800);
	$('#footer').css('left',(window_width/2)-(object_width/2)).css('top',($(window).height()-20));
	$('#makeMeScrollable').css('left',(window_width/2)-($('#makeMeScrollable').width()/2));
	$('#s_h').css('left',(window_width/2)-(object_width/2)+50);
};
move_div();

$('#t_log2').hover(function(){
	$.ajax({
		url:'widgets/login_pop.php',
		success:function(data){
		$('#login_pop2').html(data).css('width',230).css('height',120);
		$('#login_pop2').show();
		$('#login_pop1').hide();				
		}
	});
});


$('#large_login_button').click(function(){
	$.ajax({
		url:'widgets/login_pop.php',
		success:function(data){
		$('#login_pop1').html(data).css('width',230).css('height',120);
		$('#login_pop1').show();
		$('#login_pop2').hide();		
		}
	});
});

$(window).resize(function(){
	move_div();
});

$('#t_latest').click(function(){
	$.ajax({
		url:'feature_page.php?feature=1',
		success:function(data){
		$('#profile_align').html(data);
		}
	});
});

$('#t_mostread').click(function(){
	$.ajax({
		url:'feature_page.php?feature=2',
		success:function(data){
		$('#profile_align').html(data);
		}
	});
});

$('#t_recommendedbypeople').click(function(){
	$.ajax({
		url:'feature_page.php?feature=3',
		success:function(data){
		$('#profile_align').html(data);
		}
	});
});

$('.article_list_box').mouseenter(function(){
	$('#b_art_title',this).stop().animate({ 'top': -140 },800);
});
$('.article_list_box').mouseleave(function(){
	$('#b_art_title',this).stop().animate({ 'top': -35 },800);
});

});