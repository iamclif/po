	$(document).ready(function() {
		//logo clickable
		$('#logo').css('cursor', 'pointer')
				  .click(function() {
				 window.location=base_url;
		});
		
		//gallery cover effect
		$('.gallery_cover h3').css('opacity', 0);
		$('.gallery_cover').hover(function() {
			$(this).children('h3').stop().animate({opacity : 1 }, 'slow');
		}, function() {
			$(this).children('h3').stop().animate({opacity : 0 }, 'slow');
		});
		$('.gallery_cover').click(function() {
			 window.location=$(this).find('a').attr('href');
			 return false;
		});
		
		//photos thumb effects
		$('.gallery_overlay').css('background', '#000')
							 .animate({opacity : 0 }, 'slow');
		
		$('.gallery_overlay').hover(function() {
			$(this).css({'cursor' : 'pointer', 'border' : '2px solid #fff'})
				   .stop()
				   .animate({opacity : .5 }, 'slow');
		}, function() {
			$(this).stop().animate({opacity : 0 }, 'slow');
		});

	});
	
	//contact form
	$('#name').focus(function() { if( this.value == 'name' ) { this.value = ''; }} )
			  .blur(function() { if( this.value == '' ) { this.value = 'name'; }} );
			  
	$('#email').focus(function() { if( this.value == 'email' ) { this.value = ''; }} )
			   .blur(function() { if( this.value == '' ) { this.value = 'email'; }} );
			  
	$('#message').focus(function() { if( this.value == 'message' ) { this.value = ''; }} )
			  	 .blur(function() { if( this.value == '' ) { this.value = 'message'; }} );