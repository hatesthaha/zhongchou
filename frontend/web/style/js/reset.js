$(function(){
    var UA=window.navigator.userAgent;  //使用设备
    var CLICK="click";
    if(/ipad|iphone|android/.test(UA)){   //判断使用设备
        CLICK="tap";
    };
    $(".mask-share").css("height",$(window).height());
    $("body").width($(window).width());
	$("body").css("min-height",$(window).height());
    $(".bodyA").css("height",$("body").height());
	$("#body_h").css("min-height",$(window).height());
    var B = $(window).width()/320*100*0.625+"%";
    $("html").css("font-size",B);
    //表单验证
    $(".img3").each(function(){
        $(this).height($(this).width()*0.4);
    });
})