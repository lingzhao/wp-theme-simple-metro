jQuery(document).ready(function(){
    $("li.header-cats").hover(function(){
        $(this).children("ul").stop().show()
    },function(){
        $(this).children("ul").stop().hide()
    })
        
     $('#comment').keypress(function(e){
            if(e.ctrlKey && e.which == 13 || e.which == 10) {
                   $('#commentform').submit();
                  }
                });
      
});

