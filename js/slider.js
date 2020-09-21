$(document).ready(function(){

    let indice = 1;

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

});