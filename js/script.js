$(function() {
    'use strict';

    //slider

    let indice = 1;

    if ($('.slider-img').length > 0) {
        
        muestraSlider(indice);

        $('.atras').click(function(){
            avanzaSlider(-1);
        });
    
        $('.adelante').click(function(){
            avanzaSlider(1);
        });
    
        function avanzaSlider(n){
            muestraSlider(indice+=n);
        }
    
        function posicionSlider(n){
            muestraSlider(indice=n);
        }
    
        setInterval(function tiempo(){
            muestraSlider(indice+=1)
        }, 3000);
    
        function muestraSlider(n){
            let i;
    
            let slider = document.getElementsByClassName('slider-img');
    
            if(n > slider.length){
                indice = 1;
            } 
            if (n < 1){
                indice = slider.length;
            }
            for(i=0; i < slider.length; i++){
                slider[i].style.display = 'none';
            }
    
            slider[indice-1].style.display = 'block';
        }

    }

    

    // ir arriba

    $('.ir-arriba').click(function(){
        $('body, html').animate({
            scrollTop: '0px'
        }, 500);
    });

    $(window).scroll(function(){
        if ($(window).width() > 600) {
            if($(this).scrollTop() > 0 ){
                $('.ir-arriba').slideDown(500);
            } else {
                $('.ir-arriba').slideUp(500);
            }
        } else {
            $('.ir-arriba').hide();
        }

        
    });

    //Menu

    var altura = $('.header-restaurante').height();
	
	$(window).on('scroll', function(){
		if ( $(window).scrollTop() > altura ){
			$('.header-restaurante nav').addClass('menu-fixed');
		} else {
			$('.header-restaurante nav').removeClass('menu-fixed');
		}
	});

});