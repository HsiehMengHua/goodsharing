$(document).ready(function() {
  $(window).scroll(function(){
    $('.grid-item').each(function(i){
      var top_of_object = $(this).offset().top;
      var bottom_of_object = top_of_object + $(this).outerHeight();
      var bottom_of_window = $(window).scrollTop() + $(window).height();
      var offset = 50;

      if( bottom_of_window > top_of_object + offset ){
        $(this).addClass("fadeInUp");
        //$(this).parent().addClass("rotateInUpLeft");
      }
    });
  });  
});
