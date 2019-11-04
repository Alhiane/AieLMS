$(function(){

    'use strict';
    // toggle between grid view & list view Mange Book page

    $('.pull-right i').on('click', function(){

      $(".item-books").fadeToggle();

      $("table").fadeToggle();

    });

    // Show / Hide option full-view categories
    
    $('.cat h4').click(function () {

      $(this).next('.full-view').fadeToggle(250);
    }); 

    $('.Option span').click(function (){

      $(this).addClass('active').siblings('span').removeClass('active');

      if ($(this).data('view') === 'full'){

        $('.cat .full-view').fadeIn(200);

      }else{

        $('.cat .full-view').fadeOut(200);

      }


    });

    // live view user information
    $('.live-user').keyup(function () {
      $('.live-perview h5').text($(this).val());
    });

    $('.live-name').keyup(function () {
      $('.live-perview .name').text($(this).val());
    });

    $('.live-email').keyup(function () {
      $('.live-perview .email').text($(this).val());
    });

    // toggle between Settings tab in Page settings

    $('.setting-tab li').click(function() {
      $(this).addClass('active').siblings('li').removeClass('active');
      $('.content .each').hide();
      $('.' + $(this).data('class')).fadeIn();
    });

    
});

// Ajax request for Settings page
    function sett(reqType){
      var xhr = new XMLHttpRequest();

      var title = document.getElementById("title").value;
      var desc = document.getElementById("desc").value;
      var logo = document.getElementById("logo").value;
      var icon = document.getElementById("icon").value;

      xhr.onreadystatechange = function(){
          if (xhr.readyState == 4 && xhr.status == 200 ) {
              document.getElementById("reponse").innerHTML = xhr.responseText;
          }
      }
      xhr.open("POST", "AjaxRequest.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("reqType="+reqType+"&title="+title+"&desc="+desc+"&logo="+logo+"&icon="+icon);  
   }


