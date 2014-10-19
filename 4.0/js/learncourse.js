var learn={
	init:function(){
		this.bindEle();
         //this.cor();
         this.numberNav();
         
	},
	clicknumber:0,
	bindEle:function(){
		$('.list-question span').bind("click",{"class":"list-content","navClass":"active"},jkcommon.pageChange)
	},
	cor:function(){
		jkcommon.setPosition("positionthis","learn-flex",906);
	},
	numberNav:function(){
		// var clicknumber =0;
		var _number = $('.f-numberbox a').size();
		var boxlen = _number*53/260;
		if(_number*53%260 > 0){
			boxlen+1;
		}
		$('.f-numberbox').width(_number*53);

		$('.spanLeft').click(function(){
			if(learn.clicknumber>0){
				learn.clicknumber--;
				TweenMax.to($('.f-numberbox'), 0.3, {left:-260*learn.clicknumber,ease:Linear.easeNone});
			};
			$('.showtitle').hide();
		});

		$('.spanRight').click(function(){
			if(learn.clicknumber<boxlen-1){
				learn.clicknumber++
				TweenMax.to($('.f-numberbox'), 0.3, {left:-260*learn.clicknumber,ease:Linear.easeNone});
			}
			$('.showtitle').hide();

		});

		$(".rightNum a").bind("mouseover",function(){
			var _index = $(this).index();
			var _text = $(this).attr("text")
			if(_text==''||_text==undefined){
				$('.showtitle').hide();
				return false;
			}
			$('.showtitle').css("left",_index*50-30+learn.clicknumber*(-260)+_index*2)
			$('.showtitle').show();
			$('.ue-course-title p').html(_text)
		});
		$(".rightNum a").bind("mouseout",function(){
			$('.showtitle').hide();
		})

	}

}


$(function(){
	learn.init();
})

