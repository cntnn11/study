var tnn = $.extend(tnn, {
	initialize: function(){
		return this;
	},
	/* 
	 *	@params dom obj
	 *		dom.attr = "{tit:'', input:'text/textarea/select/checkbox/radio', format: { empty:true, email:false, phone:false, tel:true, len:[0, 30], repeat: {re_id:'$re_id', input:'text', name_zh:'中文提示名'}, ajaxUnique: {url:'$url', data_name:'data_name'} } }"
	 *		EXP： var data_format	= {tit:'', input:'text/textarea/select/checkbox/radio', format: { empty:true, email:false, phone:false, tel:true, len:[0, 30], repeat:{re_id:\'password\', input:\'text\', name_zh:\'密码\'}, ajaxUnique: {url:\'/aaa/bbb.html\', data_name:\'username\'} } };
	 *	
	 */
	checkFormData: function( obj )
	{
		var result = false;
		// js错误，没有获取到对像，弹窗提示
		if( !obj )
		{
			checkFormResult(false, 'system' );
			return false;
		}
		// 没有verify说明无需验证，但是既然使用了该方法就得报错
		var data_format	= obj.attr('verify');
		if( !data_format )
		{
			eoe.msgBox(false, '错误', '系统出错了！刷新页面试试~');
			return false;
		}
		data_format	=  new Function('return '+data_format)();

		// 对值进行验证，无论是否为空
		var value	= eoe.getFormValue(obj, data_format.input );
		// 验证值，并返回错误信息
		if( obj && data_format.format && typeof(data_format.format) == 'object' )
		{
			var verify_result	= eoe.verifyFormData(obj, value, data_format.format);
			if( verify_result === true )
			{
				eoe.showSucc(obj);
				result	= true;
			}
			else
			{
				eoe.showError( obj, verify_result.replace(/\%s/g, data_format.tit) );
			}
		}
		return result;

	},
	// 获取表单元素的值
	getFormValue: function(obj, obj_type)
	{
		if( !obj )
		{
			return false;
		}
		var obj_type	= obj_type ? obj_type : 'text';
		var data		= false;
		switch( obj_type )
		{
			case 'radio':
			case 'checkbox':
			case 'select':
			case 'textarea':
			case 'text':
			default:
				data	= obj.val();
				break;
		}
		return data;
	},
	// 验证表单元素的结果值，错误返回提示语，正确返回true！
	verifyFormData: function(obj, value, format)
	{
		eoe.methods.val	= $.trim( value );
		var result		= true;
		for( var i in format)
		{
			if( typeof( eoe.methods[i] ) == 'function' )
			{
				eoe.methods.checkFormt	= format[i];
				result	= eoe.methods[i]();
				if( !result )
				{
					result	= eoe.checkFormMessages[i] ? eoe.checkFormMessages[i] : eoe.checkFormMessages['system'];
					break;
				}
			}
		}
		return result;
	},
	// 验证方法
	methods:{
		val: '',
		checkFormt: '',
		empty: function()
		{
			var result	= false;
			if( typeof(this.checkFormt) == 'boolean' && this.checkFormt && this.val )
			{
				return true;
			}
			return result;
		},
		len: function(min, max)
		{
			var val	= this.val;
			if( val.length >= this.checkFormt[0] && val.length <= this.checkFormt[1] )
			{
				return true;
			}
			return false;
		},
		num: function()
		{
			var num_val		= this.val;
			var num_preg	= new RegExp(/^\d*$/);
			if( num_val && num_preg.test(num_val) )
			{
				return true;
			}
			return false;
		},
		email: function()
		{
			var email_val	= this.val;
			var email_preg	= new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
			if( email_val && email_preg.test(email_val) )
			{
				return true;
			}
			return false;
		},
		phone: function()
		{
			var phone_val	= this.val;
			var phone_preg	= new RegExp(/^13[0-9]{1}[0-9]{8}$|15[0-9]{9}$|18[0-9]{9}$/);
			if( phone_val && phone_preg.test( phone_val ) )
			{
				return true;
			}
			return false;
		},
		repeat: function()
		{
			var re_id		= this.checkFormt.re_id;
			var val_source	= eoe.getFormValue($('#'+re_id), this.checkFormt.input );
			if( val_source && this.val && val_source == this.val )
			{
				return true;
			}
			else
			{
				var message			= eoe.checkFormMessages.repeat;
				eoe.checkFormMessages.repeat	= message.replace('%s', this.checkFormt.name_zh);
				return false;
			}
		},
		ajaxUnique: function()
		{
			var result		= true;
			var url			= this.checkFormt.url;
			var data_name	= this.checkFormt.data_name;
			var val			= this.val;
			$.ajax({
				url: url,
				data: '&'+data_name+'='+val,
				dataType: 'json',
				type: 'POST',
				async: false,
				success: function(msg){
					result	= msg.result == 'fail' ? msg['msg'] : true;
				}
			});
			return result;
		}
	},
	// 校验错误默认提示语句
	checkFormMessages: {
		empty: '请在此输入您的%s',
		len: '输入内容的长度限制在%s-%e个字数哦',
		email: '邮箱格式不正确~',
		phone: '手机号码格式正确~',
		repeat: '确保这里和%s保持一致',
		ajaxUnique: '这个%s已经存在了，换一个吧~',
		system: '啊哦！我出问题了！但我不知道问题在哪！赶快联系小雪救我 . . .'
	},
	showError: function(obj, msg)
	{
		obj.css('border', '2px solid red');
		obj.parent().find('p[class=checkError]').html('<span class="red">'+msg+'</span>');
	},
	showSucc: function(obj)
	{
		obj.css('border', '2px solid green');
		obj.parent().find('p[class=checkError]').html('');
	}
});