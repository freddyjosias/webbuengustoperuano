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
    
    console.log($('.opciones-categoria option'));
    $('.opciones-categoria option').click(function () {
        console.log('Jery');
    })

    if (window.history.replaceState) { 
        window.history.replaceState(null, null, window.location.href);
    }

    var urlMenu = window.location.pathname;
    var urlMenu = urlMenu.replace('/webbuengustoperuano/', '');
    var objectMenu ;

    if (urlMenu == 'hacerpedido.php') {
        objectMenu = $('.op1');
    } else if( urlMenu == 'bienvenida.php') {
        objectMenu = $('.op0');
    } else if( urlMenu == 'nosotros.php') {
        objectMenu = $('.op2');
    } else if( urlMenu == 'carrito.php') {
        objectMenu = $('.op3');
    }

    if (objectMenu != undefined) {
        objectMenu.parent().css('background-color', '#969696');
        objectMenu.parent().css('border', '1px solid white');
    }
    

});

