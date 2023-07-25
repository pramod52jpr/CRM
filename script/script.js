$(document).ready(()=>{
    $(".hampburger").click(()=>{
        var width=$(".drawer").css("width");
        $(".drawer").animate({width:width=="0px"?"230px":"0px"},400);
    })
    $(".myaccount").slideUp(1);
    $(".hello").click(()=>{
        $(".myaccount").slideToggle(300);
    })
})