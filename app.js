//========================
// AOS
//========================

AOS.init({
    duration:1000,
    once:true
});

//========================
// Navbar Scroll
//========================

$(window).scroll(function(){

    if($(this).scrollTop()>60){

        $('.navbar').css({
            background:'#0d6efd',
            padding:'12px 0',
            transition:'.3s'
        });

    }else{

        $('.navbar').css({
            background:'rgba(13,110,253,.15)',
            padding:'20px 0'
        });

    }

});

//========================
// Contadores
//========================

$('.counter').each(function(){

    $(this).prop('Counter',0).animate({

        Counter:$(this).text()

    },{

        duration:2500,

        easing:'swing',

        step:function(now){

            $(this).text(Math.ceil(now));

        }

    });

});

//========================
// Botão Voltar ao Topo
//========================

$('body').append(

'<div id="topButton"><i class="bi bi-arrow-up"></i></div>'

);

$('#topButton').css({

    position:'fixed',

    bottom:'30px',

    right:'30px',

    width:'55px',

    height:'55px',

    background:'#0d6efd',

    color:'#fff',

    borderRadius:'50%',

    display:'flex',

    justifyContent:'center',

    alignItems:'center',

    cursor:'pointer',

    fontSize:'24px',

    display:'none',

    zIndex:'9999',

    boxShadow:'0 10px 25px rgba(0,0,0,.25)'

});

$(window).scroll(function(){

    if($(this).scrollTop()>250){

        $('#topButton').fadeIn();

    }else{

        $('#topButton').fadeOut();

    }

});

$('#topButton').click(function(){

    $('html,body').animate({

        scrollTop:0

    },700);

});

//========================
// Hover Serviços
//========================

$('.service-card').hover(function(){

    $(this).find('.icon').css({

        transform:'rotate(360deg)',
        transition:'.6s'

    });

},function(){

    $(this).find('.icon').css({

        transform:'rotate(0deg)'

    });

});

//========================
// Galeria
//========================

$('.gallery').click(function(){

    Swal.fire({

        imageUrl:$(this).attr('src'),

        imageWidth:700,

        imageAlt:'Imagem',

        showConfirmButton:false,

        background:'#fff',

        width:'900px'

    });

});

//========================
// Contacto
//========================

$('form').submit(function(e){

    e.preventDefault();

    Swal.fire({

        icon:'success',

        title:'Mensagem enviada!',

        text:'Entraremos em contacto consigo brevemente.',

        confirmButtonColor:'#0d6efd'

    });

});

//========================
// Efeito Botões
//========================

$('.btn').mouseenter(function(){

    $(this).css({

        transform:'translateY(-4px) scale(1.03)',

        transition:'.3s'

    });

});

$('.btn').mouseleave(function(){

    $(this).css({

        transform:'translateY(0)'

    });

});

//========================
// Loader
//========================

$(window).on('load',function(){

    $('#loader').fadeOut(800);

});

//========================
// Texto Hero
//========================

let texto="A sua roupa impecável, sem sair de casa.";

let i=0;

function escrever(){

    if(i<texto.length){

        $('#typed').append(texto.charAt(i));

        i++;

        setTimeout(escrever,50);

    }

}

// escrever();

//========================
// Cards
//========================

$('.service-card').mouseenter(function(){

    $(this).css({

        transform:'translateY(-15px) scale(1.03)'

    });

});

$('.service-card').mouseleave(function(){

    $(this).css({

        transform:'translateY(0)'

    });

});