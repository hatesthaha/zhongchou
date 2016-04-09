window.onload=function(){
	//首页头部导航部分按钮的高
	$(".modular3 .modular3-img").each(function(){
		var TH = $(this).width();
		var THIMG = $(this).find("img").width();
		$(this).height(TH);
		$(this).find("img").css("margin-top",(-THIMG)/2);
	});
	//页面上方显示的众筹项目右边图片的高
	$(".img1").height($(".img1").width());
	$(".project-left2").height(($(".project-left1").height()-1)/2);
	$(".img3").each(function(){
		$(this).height($(this).width()*0.4);
	});
	//页面显示的众筹项目下边图片的高
	//不间断滚动公告部分开始
	$(function(){
		var $this = $(".notice");
		var scrollTimer;
		$this.hover(function(){
			clearInterval(scrollTimer);
		},function(){
			scrollTimer = setInterval(function(){
				scrollNews( $this );
			}, 2000 );
		}).trigger("mouseout");
	});
	function scrollNews(obj){
		var $self = obj.find("ul:first");
		var lineHeight = $self.find("li:first").height();  
		$self.animate({ "margin-top" : -lineHeight +"px" },600 , function(){
			$self.css({"margin-top":"0px"}).find("li:first").appendTo($self);
		})
	}    
	//不间断滚动公告部分结束
	//圆形进度条开始
	$('.circle').each(function(index, el) {
		var num = $(this).find('.NUM').text() * 3.6;
		if (num<=180) {
			$(this).find('.right').css('transform', "rotate(" + num + "deg)");
		} else {
			$(this).find('.right').css('transform', "rotate(180deg)");
			$(this).find('.left').css('transform', "rotate(" + (num - 180) + "deg)");
		};
	});
	//圆形进度条结束
	$(".project-left2").height(($(".project-left1").height()-1)/2);
	var el = $(".hui-pagerq");
	grayscale( el );
	$(".bodyA").hide();
};
