$(function() {
  $('form input').on("focus",function(){
    $(this).parent().css("color","#55bbb5");
    $(this).css("borderBottomColor","#55bbb5");
    $(this).css("borderBottomWidth","2px");
  });
  $('form input').on("blur",function(){
    $(this).parent().css("color","#313b4f");
    $(this).css("borderBottomColor","#313b4f");
    $(this).css("borderBottomWidth","1px");
  });
  $('form textarea').on("focus",function(){
    $(this).parent().css("color","#55bbb5");
    $(this).css("borderBottomColor","#55bbb5");
    $(this).css("borderBottomWidth","2px");
  });
  $('form textarea').on("blur",function(){
    $(this).parent().css("color","#313b4f");
    $(this).css("borderBottomColor","#313b4f");
    $(this).css("borderBottomWidth","1px");
  });
});