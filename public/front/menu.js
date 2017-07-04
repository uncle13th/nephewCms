function openPage(url, type){
    window.open(url, type);
}
$(function(){
    $(".navlist li.dropdown").on('click', function(){
        var href_url = $(this).find('a').eq(0).attr('href');
        console.log(href_url);
        var target_type = $(this).find('a').eq(0).attr('target');
        console.log(target_type);
        openPage(href_url, target_type)
    })

    $(".nav-shop li.dropdown").hover(function(){
        $(this).addClass('open');
    },function(){
        $(this).removeClass('open')
    })


})