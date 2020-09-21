$(document).ready(function(){
    
	var altura = $('.header-restaurante').offset().top;
	
	$(window).on('scroll', function(){
		if ( $(window).scrollTop() > altura ){
			$('.header-restaurante nav').addClass('menu-fixed');
		} else {
			$('.header-restaurante nav').removeClass('menu-fixed');
		}
	});
 
});