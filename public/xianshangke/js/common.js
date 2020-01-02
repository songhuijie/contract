const baseUrl = "file:///C:/Users/Administrator/Desktop/线上客登录"
$(".list").on("click","li",function(e){
    $(".list > li").removeClass("li_border_left")
    $(this).addClass("li_border_left")
    if(e.target.innerText == " 首页"){
        console.log(1111)
        
        window.location.href = baseUrl + "/home.html"
    }else if(e.target.innerText == " 商户"){
        window.location.href = baseUrl + "/merchants/home.html"
    }else if(e.target.innerText == " 分润"){
        window.location.href =  baseUrl  +"/FenRun/home.html"
    }else if(e.target.innerText == " 资金"){
        window.location.href =  baseUrl + "/money/home.html"
    }else if(e.target.innerText == " 应用"){
        window.location.href =  baseUrl + "/application/home.html"
    }else if(e.target.innerText == " 用户"){
        window.location.href =  baseUrl +"/user/home.html"
    }
})
$(".left_two>ul").on("click","li",function(){
    $(".left_two li").removeClass("active")
    $(this).addClass("active")
})