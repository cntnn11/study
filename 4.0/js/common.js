var mouselock=0;
var jkcommon = {
	init:function(){
	  this.bindElement();
	  this.navflex();
	  this.lessImgShow();
	  this.imgMoveFunc();
	},
	clicknumber:0,
	stopEventBubble: function(event){
		var e=event || window.event;

		if (e && e.stopPropagation){
		    e.stopPropagation();    
		}
		else{
		    e.cancelBubble=true;
		}
	},
	bindElement:function(){
		$('.navbox span').bind("mouseover",this.topNav);
		$('.user-name').bind("mouseover",this.myNav)
		
		
	},
	myNav:function(){

		$('.login-success').show();
		$(document).bind("mouseover",function(){
			$('.login-success').hide();
		})

		$('.loginbox').bind("mouseover",function(e){
			jkcommon.stopEventBubble(e);
		});

	},
    pageChange:function(e){//页签切换
       var navClass = e.data.navClass;

        $(this).siblings().removeClass(navClass);
        $(this).addClass(navClass);
    	var _index = $(this).index();
    	console.log("_index",_index)
 		var _className = $("."+e.data.class) ;
 		_className.hide();
 		_className.eq(_index).show();  	
 

    },
	topNav:function(){//头部导航切换
		var _index = $(this).index();
		console.log(_index)
		switch(_index)
		{
		case 1:
		 $('.trangle').css("marginLeft","44px")
		  break;
		case 2:
		  $('.trangle').css("marginLeft","155px")
		  break;
		  case 3:
		   $('.trangle').css("marginLeft","260px")
		  break;
		  case 4:
		   $('.trangle').css("marginLeft","360px")
		  break;
		  case 5:
		   $('.trangle').css("marginLeft","460px")
		  break;
		  
		}
		$('.pulldownbox').mouseover(function(){
			$(this).show();
			
		})
		$('.pulldownbox').mouseout(function(){
			$(this).hide();
			
		})

		$('.logobox').mouseover(function(){
			$('.pulldownbox').hide();
		})

		$('.navbox span').removeClass("greencolor")
		$(this).addClass("greencolor");
		$('.pulldownbox').show();
		$('.showbox').hide();
		$('.showbox').eq(_index-1).show();
		
		
	},
	navflex:function(){//头部定位
		$(document).scroll(
			function(){
			var _top = $(document).scrollTop();
			if(_top>=70){
				$('.ue-box').addClass("flex")
			} else{
				$('.ue-box').removeClass("flex")
			}
		});
	},
 	setPosition:function(clas,setpos,data){
		$(document).scroll(
			function(){
			var _top = $(document).scrollTop();
			alert("_top",_top)
			if(_top>=data){

				$("."+clas).addClass(setpos)
			} else{

				$('.'+clas).removeClass(setpos)
			}


		});
 	},
 	lessImgShow:function(){
 		$('.lessonimgbox').bind("mouseover",function(e){
 			if(mouselock == 0){

	 			var _pop = $(this).find(".img-pop");
	 			$(this).css({border:"2px solid #1abc9c",width:"226px",height:"226px"});
	 			console.log(_pop)
	 			TweenMax.to(_pop, 0.4, {top:0,sease:Bounce.easeOut});
	 			jkcommon.stopEventBubble(e);
	 		}
		});
		$('.classif-tow').bind("click",function(){
			mouselock = 1;
			$(this).css("backgroundPosition","-30px 0px");
			$('.classif-one').css("backgroundPosition","0px 0px");
			$('.lessonimgbox').css({border:"0",width:"750px",height:"130px"});
			$('.lessonimgbox').addClass('lessonimgbox2').removeClass('lessonimgbox');
		});

		$('.classif-one').bind("click",function(){
			mouselock =0;
			$(this).css("backgroundPosition","0px -30px");
			$('.classif-tow').css("backgroundPosition","-30px -30px");
			$('.lessonimgbox2').css({border:"0",width:"230px",height:"230px"});
			$('.lessonimgbox2').addClass('lessonimgbox').removeClass('lessonimgbox2');
		})

 		$(document).bind("mouseover",function(){
 			$('.lessonimgbox').css({border:"0",width:"230px",height:"230px"});
 			var _pop = $(this).find(".img-pop");
 			TweenMax.to(_pop, 0.4, {top:230,ease:Linear.easeNone});
 		})

 	},
 	imgMoveFunc:function(){
    	var number = $('.smallcardlist a').size();
    	var length =number*230;
    	$('.smallcardlist').width(length);

		var boxlen = length/690;
		if(boxlen%690 > 0){
			boxlen+1;
		}
		console.log("boxlen",boxlen)

		$('.left-textbox .prev-btn').click(function(){
			if(jkcommon.clicknumber>0){
				jkcommon.clicknumber--;
				TweenMax.to($('.smallcardlist'), 0.3, {left:-690*jkcommon.clicknumber,ease:Linear.easeNone});
			};
			$('.showtitle').hide();
		});

		$('.left-textbox .next-btn').click(function(){
			if(jkcommon.clicknumber<boxlen-1){
				jkcommon.clicknumber++
				TweenMax.to($('.smallcardlist'), 0.3, {left:-690*jkcommon.clicknumber,ease:Linear.easeNone});
			}
			$('.showtitle').hide();

		});


 	}

}




$(function(){
	jkcommon.init();
})

