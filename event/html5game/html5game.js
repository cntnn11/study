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
// 登录按钮
console.log('状态 -> ',  typeof(eoe), isLogin );
$('.reg-btn').click(function(){
	if( typeof(eoe) == 'undefined' )
	{
		window.location='http://www.jikexueyuan.com/sso/login.html';
	}
	else
	{
		if( isLogin )
		{
			window.location='http://www.jikexueyuan.com';
		}
		else
		{
			eoe.dialogin();
		}
	}
});
console.log(decodeURIComponent('%E8%BF%99%E6%98%AF%E4%B8%80%E4%B8%AAphper%E5%86%99%E7%9A%84%E9%A1%B5%E9%9D%A2%E3%80%82%E5%89%8D%E7%AB%AF%E5%A4%A7%E5%B8%88%EF%BC%8C%E5%BF%AB%E6%9D%A5%E8%A7%A3%E6%95%91%E4%BB%96%E5%90%A7%EF%BC%81%E4%BC%9A%E5%93%8D%E5%BA%94%E5%BC%8F%E3%80%81canvas%EF%BC%8Cjs%E7%9A%84%E5%A4%A7%E5%B8%88%E5%BF%AB%E6%9D%A5%E8%A7%A3%E6%95%91%E4%BB%96%E5%90%A7~ '));