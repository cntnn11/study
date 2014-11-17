$(document).ready(function(){

	//幻灯片元素与类“menu_body”段与类“menu_head”时点击
	//$("#firstpane .menu_body:eq(0)").show();

	$("p.current").next("div.menu_body").show();
	
	$("#zeropane h2.menu_titlelist").click(function(){
		$(this).addClass("current").siblings("#firstpane").children("div.menu_body").slideUp("slow")
		$(this).siblings().removeClass("current");
	});
	
	$("#firstpane p.menu_head").click(function(){
		$(this).addClass("current").next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
		$(this).siblings().removeClass("current");
	});
	
		$("li").click(function(){
		$(this).addClass("current");
		$(this).siblings().removeClass("current");
	});

	
	//滑动与类“menu_body”的元素，当鼠标悬停段
	//$("#secondpane .menu_body:eq(0)").show();
//	$("#secondpane p.menu_head").mouseover(function(){
//		$(this).addClass("current").next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
//		$(this).siblings().removeClass("current");
//	});
	});



	
