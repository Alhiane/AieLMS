/*Ajax Request*/
 /* 1 /* Check user information registion & valid it  */
 function user(reqType){
    var xhr = new XMLHttpRequest();

    var user = document.getElementById("uuser").value;

    xhr.onreadystatechange = function(){
        if (xhr.readyState == 4 && xhr.status == 200 ) {
            document.getElementById("userreq").innerHTML = xhr.responseText;
        }
    }
    xhr.open("POST", "Ajaxreq.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("reqType="+reqType+"&user="+user);  
 }

 /* 1 /* END  */
/*End Ajax Request*/

/* Function run Slider Show in Index.php & categories */
var owl = $('.on-same-category .owl-carousel');
owl.owlCarousel({
    items:9,
    loop:true,
    margin:0,
    autoplay:true,
    autoplayTimeout:2000,
    autoplayHoverPause:true,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:5,
            nav:false,
            loop:true
        }
    }
});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[1000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
});
/*End Function run Slider Show in Index.php & categories */
 
/* Slider Dashborde User Best Downoldes*/
var owl = $('.user-uplodes .owl-carousel');
owl.owlCarousel({
    items:5,
    loop:true,
    margin:0,
    autoplay:true,
    autoplayTimeout:2000,
    autoplayHoverPause:true
});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[1000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
});
/* Function run Slider Show in Index.php & categories */
var owl = $('.owl-carousel');
owl.owlCarousel({
    items:6,
    loop:true,
    margin:0,
    autoplay:true,
    autoplayTimeout:2000,
    autoplayHoverPause:true
});
$('.play').on('click',function(){
    owl.trigger('play.owl.autoplay',[1000])
})
$('.stop').on('click',function(){
    owl.trigger('stop.owl.autoplay')
});
/*End Function run Slider Show in Index.php & categories */
$(function(){

	'use strict';

    /* Fixed the navbar */
    $(window).scroll(function() {
            if ($(".nav-menu").offset().top > 70) {
                $(".nav-menu").addClass("navbar-coll");
            } else {
                $(".nav-menu").removeClass("navbar-coll");
            }
    });

    /* fixed the seconde navigation */
   
    
    /* Toggle dropdwon */    
    $('.bars li').click(function() {
        $('.dropdown').fadeToggle();
    });

    $('.menu .bars').click(function() {
        $('.dropdown').fadeToggle();
    });

     /* Ajax pagination Index */
     $(document).ready(function(){
            load_data();
            function load_data(page){
                $.ajax({
                    url:"pagination.php",
                    method:"POST",
                    data:{page:page},
                    success:function(data){
                        $('#data_pagination').html(data);
                    }
                })
            }

            $(document).on('click', '.pagination_link', function(){
                var page = $(this).attr("id");
                load_data(page);
            })
        });  

    /* Show Edit User information  -- Dashbord.php profile --*/
    $('.user-info .fa-edit').click(function(){
        $('#list-profile .user-uplodes').fadeToggle(50);
        $('.edit-info').fadeToggle(400);
    });

    /* End Show Edit User information  -- Dashbord.php profile --*/
    $('.catename li').click(function(){
    		$(this).addClass('selected').siblings().removeClass('selected');		
    		$('.catcontent .books').hide();
    		$('.' + $(this).data('class')).fadeIn();
    	});

    /* Toggle between login & sinup */
    $('h3 .login').click(function () {

          $('.loginform').fadeIn(0);
          $('.signupform').fadeOut(0);

    });

    $('h3 .signup').click(function () {

          $('.loginform').fadeOut(0);
          $('.signupform').fadeIn(0);

    });
});
