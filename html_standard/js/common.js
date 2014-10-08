/**
 * @author		jiangtao.cao
 * @version		1.0
 * @date		2014-4-28
 * 
 */

$(function(){
	var $menu = $("#menu");
	var $hd = $(".c-list>.bd:not(:empty)").parent(".c-list").children(".hd")
	var num = 0;
	
	$menu.children("li").each(function(i){
		var thisLength = $menu.children("li").length;
		
		$(this).children("h2").click(function(){
			var $li = $(this).parent("li");
			
			if($li.is("[class *= 'on']")){
				$li.removeClass("on");
			}else{
				$li.addClass("on");
			};
			
			var onLength = $menu.children("[class *= 'on']").length;
			
			if(onLength == thisLength){
				$("#menuAllExpand").text("折叠全部");
			}else{
				$("#menuAllExpand").text("展开全部");
			};
		});
	});
	
	// crumbs text
	$menu.find("ol li").each(function(index){
		$(this).children("a").click(function(){
			var txt = $(this).text();
			var $li = $(this).parent("li");
			if($li.not("[class *= 'on']")){
				$menu.find("ol>li").removeClass("on");
				$li.addClass("on");
				$("#content .c-item:eq("+index+")").show().siblings().hide();
				$("#content .c-item:eq("+index+")").find(".c-list:last").addClass("last");
				$("#crumbs li:eq(1)").text(txt);
				$("#allWDS").text("当前规范");
				num = index;
			};
		});
	});
	
	//allExpand click event
	$("#menuAllExpand").click(function(){
		var txt = $(this).text();
		
		if(txt == "展开全部"){
			$(this).text("折叠全部");
			$menu.children("li").addClass("on");
		}else{
			$(this).text("展开全部");
			$menu.children("li").removeClass("on");
		};
	});
	
	//Toolbar click event
	$("#toolbar span:not(:last)").each(function(){
		$(this).click(function(){
			$("#toolbar span:not(:last)").removeClass("on");
			$(this).addClass("on");
		});
	});
	
	//onlyTitle click event
	$("#onlyTitle").click(function(){
		onlyTitle();
	});
	
	//showCont click event
	$("#showCont").click(function(){
		$(".c-item .bd").show();
		$hd.children().find("ins").remove();
  		$("#onlyTitle").bind("click",function(){
  			onlyTitle();
  		});
	});
	
	//allWDS click event
	$("#allWDS").bind("click",function(){
		$(".c-item").show();
		if($(this).text() == "当前规范"){
			$(this).text("所有规范");
			$("#crumbs li:eq(1)").text("所有规范");
			$("#menu li li").removeClass("on");
			$(".c-list.last").removeClass("last").addClass("last-bdr");
		}else{
			$(this).text("当前规范");
			$("#menu li li:eq("+num+")>a").click();
			$(".c-list.last-bdr").removeClass("last-bdr").addClass("last");
		}
	});
	$("#allWDS").trigger("click");
	
	//content show and hide
	$(".c-list>.hd>h3").click(function(){
		$thisBD = $(this).parents(".c-list").children(".bd");
		if($thisBD.is(":visible")){
			$thisBD.hide();
			$(this).append("<ins>&nbsp;&nbsp;&darr;</ins>");
		}else{
			$thisBD.show();
			$(this).children("ins").remove();
		}
	});
	
	//c-list hd cursor
	$hd.css({cursor:"pointer"});
	
	//return top
	$("#returnTop").click(function(){
		$("html,body").animate({scrollTop:0},'fast');
	});
	
	floatBox("#container","#crumbs","static","active");
	
	//IE 678 nonsupport
	$("#ie678 td:contains('IE 6不支持')").parent("tr").children("td").css({backgroundColor:"rgb(240,240,240)"});
	$("#ie678 td:contains('IE 6,7不支持')").parent("tr").children("td").css({backgroundColor:"rgb(230,230,230)"});
	$("#ie678 td:contains('IE 6,7,8不支持')").parent("tr").children("td").css({backgroundColor:"rgb(220,220,220)"});
})

function onlyTitle(){
	var $hd = $(".c-list>.bd:not(:empty)").parent(".c-list").children(".hd");

	$(".c-item .bd").hide();
	$hd.children().find("ins").remove();
	$hd.children().append("<ins>&nbsp;&nbsp;&darr;</ins>");
	$(this).unbind("click");
}
function floatBox(parentID,targetID,FixedClass,ActiveClass){
	//.fixed{position:absolute;top:0;}
	//.active{position:fixed;top:0;_margin-top:-0px;_position:absolute;_top:expression(documentElement.scrollTop+"px" );}
	$(window).scroll(function(){
		var myDivTop = $(parentID).position().top;
		var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
		if(scrollTop >= myDivTop){
			$(targetID).addClass(ActiveClass).removeClass(FixedClass);
		}else{
			$(targetID).addClass(FixedClass).removeClass(ActiveClass);
		};
	});
}