$("#sidebar ul.nav li a.hasChild").click(function(){
    var obj = $(this);
    var child_ul = obj.next();
    
    if(child_ul.hasClass('nav-sub'))
    {
        obj.children(':last').removeClass('right-caret').addClass('caret');
        
        child_ul.removeClass('nav-sub');
    }else{
        obj.children(':last').addClass('right-caret').removeClass('caret');
        child_ul.addClass('nav-sub');
    }
    
    
});