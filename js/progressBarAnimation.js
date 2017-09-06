$(document).ready(function() {
  $(window).scroll(function(){
    $('.w3-progressbar').each(function(i){
      var top_of_object = $(this).parent().parent().parent().offset().top;
      var bottom_of_object = top_of_object + $(this).parent().parent().parent().outerHeight();
      var bottom_of_window = $(window).scrollTop() + $(window).height();
      var percentage = $(this).attr("data-perc");
      var offset = 150;
      
      //$(this).closest(".grid-item").css("background","red");
      
      if( bottom_of_window > bottom_of_object){
        $(this).animate({width: percentage+"px"},"slow");
      }
    });
  });
});