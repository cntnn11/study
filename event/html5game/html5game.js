/*TAB切换选项卡*/
$('.tab-btn').mouseenter(function(){
	var btn_obj	= $(this);
	$('.tab-btn').each(function(){
		$(this).removeClass('btn-main-hover');
	});

	var round_now	= btn_obj.attr('tab');
	$('.div3-tab-box').find('.div3-tab-body').each(function(){
		if( $(this).attr('class').indexOf( round_now ) >= 0 )
		{
			btn_obj.addClass('btn-main-hover');
			$(this).removeClass('hidden');
		}
		else
		{
			$(this).addClass('hidden');
		}
	});
});