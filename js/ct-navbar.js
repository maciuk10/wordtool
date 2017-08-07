searchVisible = 0;
transparent = true;
hasTransparent = false;
var headerChange = 2;

$(document).ready(function(){
   if($('nav[role="navigation"]').hasClass('navbar-transparent')){
        hasTransparent = true;
   }
   $('[data-toggle="search"]').click(function(){
        if(searchVisible == 0){
            searchVisible = 1;
            $(this).parent().addClass('active');
            $(this).children('p').html('Zamknij');
            $('.navbar-search-form').fadeIn(function(){
                $('.navbar-search-form input').focus();
            });
        } else {
            searchVisible = 0;
            $(this).parent().removeClass('active');
            $(this).children('p').html('Szukaj książki');
            $(this).blur();
            $('.navbar-search-form').fadeOut(function(){
                $('.navbar-search-form input').blur();
            });
        } 
    });
    
});

$(document).scroll(function() {
   if(hasTransparent){
       if($(this).scrollTop() > headerChange){
           $("nav[role='navigation']").addClass('navbar-ct-lowTransparency');
           $("nav[role='navigation']").removeClass('navbar-transparent');
           $(".wt_logo").addClass("wt_padding");
       }else {
           $("nav[role='navigation']").addClass('navbar-transparent');
           $("nav[role='navigation']").removeClass('navbar-ct-lowTransparency');
           $(".wt_logo").removeClass("wt_padding");
       }
    }
});