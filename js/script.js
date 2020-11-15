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

    $('.function-go-up').click(function()
    {
        $('body, html').animate(
        {
            scrollTop: '0px'
        }, 500);

    });

    $(window).scroll(function(){

        if($(this).scrollTop() > 40 )
        {
            $('.ir-arriba').slideDown(500);
        } 
        else 
        {
            $('.ir-arriba').slideUp(500);
        }

        
    });

    //Menu
    var marignWelcomePage = 0;
    
    if ($('.bienvenida-page').length > 0) {    
        marignWelcomePage = $('.bienvenida-page').css('margin-top');
    }

    var heightNavRestaurant;
    
    if ($('.nav-restaurant').height() <= 0) 
    {
        heightNavRestaurant = $('.navbar-restaurant').height();
    } 
    else 
    {
        heightNavRestaurant = $('.nav-restaurant').height();
    }

    var altura = $('.header-restaurante').height();
    
    function fixedMenu(){
        
        $(window).on('scroll', function(){

            if ($(window).width() < 992) {

                $('.logo-icono').css('top', -1 * $(window).scrollTop());
                
            } else 
            {

                $('.logo-icono').css('top', '1px');

            }

            if ( $(window).scrollTop() > altura )
            {

                $('.header-restaurante nav').addClass('menu-fixed');

                if ($('.bienvenida-page').length > 0) { 
                    console.log(marignWelcomePage);
                    $('.bienvenida-page').css('margin-top', parseInt(marignWelcomePage) + parseInt(heightNavRestaurant))

                } else if ($('.carta').length > 0) {

                    $('.carta').css('margin-top',heightNavRestaurant)

                }


            }
            else 
            {

                $('.header-restaurante nav').removeClass('menu-fixed');
                
                if ($('.bienvenida-page').length > 0) {    
                    $('.bienvenida-page').css('margin-top', 32);
                    marignWelcomePage = $('.bienvenida-page').css('margin-top');
                } else if($('.carta').length > 0) {
                    $('.carta').css('margin-top', 0);
                }

                if ($('.nav-restaurant').height() <= 0) 
                {
                    heightNavRestaurant = $('.navbar-restaurant').height();
                } 
                else 
                {
                    heightNavRestaurant = $('.nav-restaurant').height();
                }

                altura = $('.header-restaurante').height() - heightNavRestaurant;

            }

        });
    
    }

    fixedMenu();

    $(window).resize(function () {
        
        fixedMenu();

    });
    
    $('.opciones-categoria option').click(function () {
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


    // ADD MANAGER

    $('.buttom-add-manager').click(function () {
        $('.form-add-manager').slideDown();
        $(this).hide();
    })

    $('.cancel-add-manager').click(function () {
        $('.form-add-manager').slideUp();
        $('.buttom-add-manager').show();
    })

    //ADD ADMIN

    $('.button-add-admin').click(function () {
        $('.form-add-admin').slideDown();
        $(this).hide();
    })

    $('.cancel-add-admin').click(function () {
        $('.form-add-admin').slideUp();
        $('.button-add-admin').show();
    })

    //MENU ADMIN

    if ($('.this-is-manager').length > 1) {
        $('.this-is-manager:first').css({
            'background-color': '#969696',
            'border': '1px solid white'
        })
    }

    if ($('.this-is-restaurant').length > 1) {
        $('.this-is-restaurant:first').css({
            'background-color': '#969696',
            'border': '1px solid white'
        })
    }

    if ($('.this-is-admin').length > 1) {
        $('.this-is-admin:first').css({
            'background-color': '#969696',
            'border': '1px solid white'
        })
    }

    //MENU MANAGER

    if ($('.this-is-welcome-page').length > 1) {
        $('.this-is-welcome-page:first').css({
            'background-color': '#969696',
            'border': '1px solid white'
        })
    }

    if ($('.this-is-about-us-page').length > 1) {
        $('.this-is-about-us-page:first').css({
            'background-color': '#969696',
            'border': '1px solid white'
        })
    }

    if ($('.this-is-categories').length > 1) {
        $('.this-is-categories:first').css({
            'background-color': '#969696',
            'border': '1px solid white'
        })
    }

    if ($('.this-is-products').length > 1) {
        $('.this-is-products:first').css({
            'background-color': '#969696',
            'border': '1px solid white'
        })
    } 

    //MENU USUARIO

    if ($('.this-is-my-dates').length > 1) {
        $('.this-is-my-dates:first').css({
            'background-color': '#969696',
            'border': '1px solid white'
        })
    } 

});

$('.form-add-manager').hide();
$('.form-add-admin').hide();