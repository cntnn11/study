var JkTop={
	init:function(){
	  this.lessonCard();
	  this.bindElement();
	},
	clickNumber:0,
	bigCardNumber:1,
	bindElement:function(){
			$('.learnbox-right').bind("mouseenter",{a:"1"},this.Howtolearn);
			$('.learnbox-left').bind("mouseenter",{a:"2"},this.Howtolearn);

	
	},
	Howtolearn:function(e){
		var lock = e.data.a;
		if(lock == "1"){
			$('.learnbox-left').find(".greenbtn").removeClass('greenbtn').addClass("garybtn");
		} else {
			$('.learnbox-left').find(".garybtn").removeClass('garybtn').addClass("greenbtn");
		}

	},
	lessonCard:function(){//路径图动画
		var _length = $('.jkcard').size();
		$('.listbox').width(_length*197);
		for(var i= 0; i<_length; i++){
			$('.jkcard').eq(i-1).css("left",i*197)
		}
		var threeCard = $('.jkcard').eq(1);
		var towCard = $('.jkcard').eq(0);
		var fourCard = $('.jkcard').eq(2);
		TweenMax.to($('.jkcard'), 0.3, {opacity:0.4,ease:Bounce.easeOut});
		TweenMax.to(threeCard, 0.3, {scaleX:1.5,scaleY:1.5,zIndex:50,opacity:1,ease:Bounce.easeOut});
		TweenMax.to(towCard, 0.3, {scaleX:1.3,scaleY:1.3,zIndex:40,opacity:0.7,ease:Bounce.easeOut});
		TweenMax.to(fourCard, 0.3, {scaleX:1.3,scaleY:1.3,zIndex:40,opacity:0.7,sease:Bounce.easeOut});
		
		$('.card-perv').bind("click",function(){//左边点击
			if ( JkTop.clickNumber > 0){
				JkTop.clickNumber--;
				JkTop.bigCardNumber--;
				changebig()			
			}
		});
		
		$('.card-next').bind("click",function(){//右 移动
			if ( JkTop.clickNumber < _length-5){
				JkTop.clickNumber++;
				JkTop.bigCardNumber++;
				changebig()
				
		
			}
		})
		$('.jkcard').bind("mouseover",function(){
			var _self = $(this);
			var _prev = _self.prev();
			var _next = _self.next();
			TweenMax.to($('.jkcard'), 0.2, {scaleX:1,scaleY:1,zInde:20,opacity:0.4,ease:Linear.easeNone});
			TweenMax.to(_self, 0.3, {scaleX:1.5,scaleY:1.5,zIndex:50,opacity:1,ease:Linear.easeNone});
			TweenMax.to(_prev, 0.3, {scaleX:1.3,scaleY:1.3,zIndex:40,opacity:0.7,ease:Linear.easeNone});
			TweenMax.to(_next, 0.3, {scaleX:1.3,scaleY:1.3,zIndex:40,opacity:0.7,ease:Linear.easeNone});	
				
		})
		function changebig(){
			console.log("JkTop.bigCardNumber",JkTop.bigCardNumber)
			var Big = $('.jkcard').eq(JkTop.bigCardNumber);
			var BigPrev = Big.prev();
			var BigNext = Big.next();
			TweenMax.to( $('.listbox'), 0.2, {left:-197*JkTop.clickNumber,ease:Bounce.easeOut});
			TweenMax.to($('.jkcard'), 0.3, {scaleX:1,scaleY:1,zInde:20,opacity:0.4,ease:Bounce.easeOut});
			TweenMax.to(Big, 0.3, {scaleX:1.5,scaleY:1.5,zIndex:50,opacity:1,ease:Bounce.easeOut});
			TweenMax.to(BigPrev, 0.3, {scaleX:1.3,scaleY:1.3,zIndex:40,opacity:0.7,ease:Bounce.easeOut});
			TweenMax.to(BigNext, 0.3, {scaleX:1.3,scaleY:1.3,zIndex:40,opacity:0.7,ease:Bounce.easeOut});	
		}
		
	}
	
}
$(function(){
	JkTop.init();
	/*首页tab切换效果*/
	$('.tab-btn').mouseenter(function(){
		var btn_obj	= $(this);
		$('.tab-btn').each(function(){
			$(this).removeClass('vipbox-tab-btnhover');
		});
		var round_now	= btn_obj.attr('tab');
		$('.vipbox-tab-body').find('.vipbox-tab-bblock').each(function(){
			if( $(this).attr('class').indexOf( round_now ) >= 0 )
			{
				btn_obj.addClass('vipbox-tab-btnhover');
				$(this).removeClass('none');
			}
			else
			{
				$(this).addClass('none');
			}
		});
	});

	/* 首页的文字切换效果 */
	function free_animate( )
	{
		var len	= $('#free_animate').find('strong').length;
		var id		= 1;
		$('#free_animate').find('strong[class=active]').each(function(){
			var __last_obj	= $(this);
			var last_id	= parseInt( __last_obj.attr('tab') );
				id		= last_id>=len+1 ? 1 : last_id+1;
		});

		$('#free_animate').find('strong').each(function(){
			var __obj	= $(this);
			if( parseInt( __obj.attr('tab') ) == id )
			{

				__obj.fadeIn(1500).removeClass('none').addClass('active');
			}
			else
			{
				__obj.fadeOut(1500).addClass('none').removeClass('active');
			}
		});
	}
	setInterval(free_animate, 1500);
});