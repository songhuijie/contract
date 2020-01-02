


$(".list").on("click","li",function(e){
    $(".list > li").removeClass("li_border_left")
    $(this).addClass("li_border_left")
    var int = $(this).data('id');
    $(".left_two").find("ul").removeClass("block")
    $('.left_two ul').each(function(i,v){
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

            console.log(res)
            var html = '';
            var html_content = '';
            $.each(res,function(i,v){
                if(i == 0){
                    html += "<li class=\"li_border_left\" data-id='"+i+"'>";
                    html_content += "<ul class='block'>";
                }else{
                    html += "<li class=\"\" data-id='"+i+"'>";
                    html_content += "<ul>";
                }

                html += "<img src=\"../xianshangke/"+v.icon+"\" alt=\"\"";
                html += "<a href=\"javascript:void()\">"+v.title+"</a>";
                html += "</li>";

                $.each(v.children,function(key,value){
                    html_content += "<li data-url='"+value.href+"'>"+value.title+"</li>";
                });
                html_content += "</ul>";
            });
            $('.list').append(html);
            $('.left_two').append(html_content);
            console.log(html);
            console.log(html_content);

        }
    });
    $(document).pjax('a', '#pjax-container');
    $(document).on("pjax:timeout", function(event) {
        // 阻止超时导致链接跳转事件发生
        event.preventDefault()
    });

    $.pjax({
        selector: 'a',
        container: '#container', //内容替换的容器
        show: 'fade',  //展现的动画，支持默认和fade, 可以自定义动画方式，这里为自定义的function即可。
        cache: true,  //是否使用缓存
        storage: true,  //是否使用本地存储
        titleSuffix: '', //标题后缀
        filter: function(){},
        callback: function(){}
    });
});
