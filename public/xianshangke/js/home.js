


$(".list").on("click","li",function(e){
    $(".list > li").removeClass("li_border_left")
    $(this).addClass("li_border_left")
    var int = $(this).data('id');
    $(".left_two").find("ul").removeClass("block");
    $('.left_two ul').each(function(i,v){
        console.log(i);
        if(i == int){
            $(v).addClass('block');
        }
    })
});
$(".left_two").on("click","li",function(){
    $(".left_two li").removeClass("active");
    $(this).addClass("active")
});



$(function(){
    $.ajax({
        type:"get",
        datatype:"json",
        url:"/admin/menu",
        success:function(res){
            var pathname = window.location.pathname;
            console.log(pathname);

            console.log(res);
            var html = '';
            var html_content = '';
            var href = false;
            $.each(res,function(i,v){

                for(s=0;s<v.children.length;s++){
                    if(v.children[s].href == pathname){
                        href = true;
                    }
                }
                if(href == true){
                    href = false;
                    html += "<li class=\"li_border_left\" data-id='"+i+"'>";
                    html_content += "<ul class='block'>"
                }else{
                    html += "<li class=\"\" data-id='"+i+"'>";
                    html_content += "<ul >";
                }



                html += "<img src=\"../xianshangke/"+v.icon+"\" alt=\"\"";
                html += "<a href=\"javascript:void()\">"+v.title+"</a>";
                html += "</li>";

                $.each(v.children,function(key,value){

                    html_content += "<li><a href='"+value.href+"'>"+value.title+"</a></li>";
                });
                html_content += "</ul>";
            });
            $('.list').append(html);
            $('.left_two').append(html_content);
            console.log(html);
            console.log(html_content);

        }
    });

});


