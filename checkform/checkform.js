/* 
 *	@params dom obj
 *		dom.attr = "{tit:'', input:'text/textarea/select/checkbox/radio', methods: { empty:true, email:false, phone:false, tel:true, len:[0, 30], repeat: {re_id:'$re_id', input:'text', name_zh:'中文提示名'}, ajaxUnique: {url:'$url', data_name:'data_name'} } }"
 *		EXP：
 *			var dom = $('input[name=xx]'); 
 *			var dom_verify	= {tit:'', input:'text/textarea/select/checkbox/radio', methods: { empty:true, email:false, phone:false, tel:true, len:[0, 30], repeat:{re_id:'password', input:'text', name_zh:'密码'}, ajaxUnique: {url:'/aaa/bbb.html', data_name:'username'} } };
 *	
 *	@验证步骤
 *		checkFormData -> getFormValue -> verifyFormData [ {循环处理:methods} ] -> showError/showSucc/showWait [只是给验证元素增加或删除form-check-wait/succ/error样式]
 *		判断所有的是否通过check，使用 subCheck方法，将表单（form的id）作为参数，找到该表单内部所有带ck的元素，进行验证。
 *	@TIP
 *		参与验证的dom元素必须处在同一个ID元素下，样式中必须包含"ck"指定字符
 *		
 */
var chkForm = $.extend(chkForm, {
	domObj: {},
	verify_options: {},
	checkVal: '',
	domParent: '',
	initialize: function(){
		return this;
	},
	checkFormData: function( obj, verify )
	{
		if( !obj )
		{
			this.msgBox(false, this.checkFormMessages.system );
			return false;
		}
		this.domObj	= obj;

		// verify只能是一个object对象
		if( typeof( verify ) != 'object' )
		{
			this.msgBox(false, this.checkFormMessages.system );
			return false;
		}
		// 对值进行验证，无论是否为空
		this.checkVal	= this.getFormValue(obj, verify);
		if( this.domObj && verify.methods && typeof(verify.methods) == 'object' )
		{
			this.verifyFormData( this.checkVal, verify );
		}
		else
		{
			this.msgBox(false, this.checkFormMessages.system );
			return false;
		}
	},
	// 获取表单元素的值
	getFormValue: function(obj, verify)
	{
		var obj				= typeof(obj)!='undefined' ? obj : this.domObj;
		var verify_input	= verify.input;
		if( !obj )
		{
			return false;
		}
		var data		= false;
		switch( verify_input )
		{
			case 'radio':
			case 'checkbox':
			case 'select':
			case 'textarea':
			case 'text':
			default:
				data	= this.domObj.val();
				break;
		}
		return data;
	},
	// 验证表单元素的结果值，错误返回提示语，正确返回true！
	verifyFormData: function( val, verify )
	{
		var obj		= this.domObj;
		var value	= val;
		var methods	= verify.methods;

		this.methodsFunc.val	= $.trim( value );
		for( var i in methods)
		{
			if( typeof( this.methodsFunc[i] ) == 'function' )
			{
				this.showWait('', obj);
				this.methodsFunc[i](val, methods[i], obj);
				if( obj.attr('class').indexOf('succ') < 0 )
				{
					break;
				}
			}
		}
	},
	// 验证所有的输入项，返回true or false，输入当前验证框的父级ID的值
	subCheck: function( form_id )
	{
		var result	= true;
		try{
			$('#'+form_id).find('.ck').each(function(){
				var class_name	= $(this).attr('class');
				var dom_name	= $(this).attr('name');
				if( class_name.indexOf('succ') < 0 )
				{
					var dom_verify	= new Function( 'return chkForm.verify_options.'+dom_name+'.verify')();
					chkForm.checkFormData( $(this), dom_verify );
					result	= false;
				}
			});
		}
		catch(e){
			chkForm.msgBox(false, chkForm.checkFormMessages.system );
			result	= false;
		};
		return result;
	},
	// 验证方法，一个object，不是函数
	methodsFunc:{
		val: '',
		checkFormt: '',
		empty: function(val, params)
		{
			var result	= false;
			if( typeof(params) == 'boolean' && params && val )
			{
				chkForm.showSucc();
			}
			else
			{
				//chkForm.showError( chkForm.checkFormMessages.empty.replace( /\%s/g, chkForm.verify.tit ) );
				chkForm.showError();
			}
		},
		len: function(val, params)
		{
			if( val.length >= params[0] && val.length <= params[1] )
			{
				chkForm.showSucc();
			}
			else
			{
				if(params[0]==params[1])
				{
					var errorTip	= chkForm.checkFormMessages.len.replace( /\%s\-\%e/g, params[0] );
				}
				else
				{
					var errorTip	= chkForm.checkFormMessages.len.replace( /\%s/g, params[0] );
						errorTip	= errorTip.replace( /\%e/g, params[1] );
				}
				chkForm.showError( errorTip );
			}
		},
		num: function(val)
		{
			var num_preg	= new RegExp(/^\d*$/);
			if( val && num_preg.test(val) )
			{
				chkForm.showSucc();
			}
			else
			{
				chkForm.showError( chkForm.checkFormMessages.num );
			}
		},
		email: function(val)
		{
			var email_preg	= new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
			if( val && email_preg.test( val ) )
			{
				chkForm.showSucc();
			}
			else
			{
				chkForm.showError( chkForm.checkFormMessages.email );
			}
		},
		phone: function(val)
		{
			var phone_preg	= new RegExp(/^13[0-9]{1}[0-9]{8}$|15[0-9]{9}$|18[0-9]{9}$/);
			if( val && phone_preg.test( val ) )
			{
				chkForm.showSucc();
			}
			else
			{
				chkForm.showError( chkForm.checkFormMessages.phone );
			}
		},
		repeat: function(val, params)
		{
			var re_id		= params.re_id;
			var val_source	= chkForm.getFormValue( $('#'+re_id), params.input );
			if( val_source && this.val && val_source == val )
			{
				chkForm.showSucc();
			}
			else
			{
				var message	= chkForm.checkFormMessages.repeat.replace('%s', params.name_zh);
				chkForm.showError( message );
			}
		},
		ajaxUnique: function(val, params, sourceObj)
		{
			var result		= true;
			var url			= params.url;
			var data_name	= params.data_name;
			var out			= this.out ? this.out : 2000;
			$.ajax({
				url: url,
				data: '&'+data_name+'='+val,
				dataType: 'json',
				type: 'POST',
				timeout: out,
				success: function(msg){
					if( msg.result == 'fail' )
					{
						chkForm.showError( msg['msg'], sourceObj );
					}
					else
					{
						chkForm.showSucc( msg['msg'], sourceObj );
					}
				},
				complete: function(XMLHttpRequest, status){
					if(status=='timeout')
					{
						if( typeof(params)=='object' && typeof( params.timeOutFunc ) == 'function' )
						{
							params.timeOutFunc();
						}
						else
						{
							chkForm.showError( chkForm.checkFormMessages.timeout, sourceObj );
						}
					}
					else if( status == 'error' )
					{
						if( typeof(params)=='object' && typeof( params.errorFunc ) == 'function' )
						{
							params.errorFunc();
						}
						else
						{
							chkForm.showError( chkForm.checkFormMessages.system, sourceObj );
						}
					}
				}
			});
		}
	},
	// 校验错误默认提示语句
	checkFormMessages: {
		empty: '请在此输入您的%s',
		num: '只能填入数字的，亲~',
		len: '输入内容的长度限制在%s-%e个字数哦',
		email: '邮箱格式不正确~',
		phone: '手机号码格式不正确~',
		repeat: '确保这里和%s保持一致',
		ajaxUnique: '这个%s已经存在了，换一个吧~',
		timeout: '网络原因导致数据请求失败了，确保网络畅通重新试试吧~',
		system: '啊哦！我出问题了！但我不知道问题在哪！赶快联系小雪救我 . . .',
	},
	showWait: function(msg, obj)
	{
		var msg				= typeof(msg)=='undefined' ? '' : msg;
		var domObj			= typeof(obj)=='object' ? obj : this.domObj;
			domObj.addClass('form-check-wait').removeClass('form-check-error').removeClass('form-check-succ').css('border', '2px solid orange');
		var errorParentObj	= chkForm.domParent && typeof(eval('domObj'+chkForm.domParent)) ? eval('domObj'+chkForm.domParent) : domObj;
			if( typeof(errorParentObj) == 'object' )
			{
				errorParentObj.find('.checkError').html('<span class="wait">检测中……</span>');
			}
			else
			{
				domObj.next('.checkError').html('<span class="wait">检测中……</span>');
			}
	},
	showError: function(msg, obj)
	{
		var msg		= typeof(msg)=='undefined' ? '' : msg;
		var domObj	= typeof(obj)=='object' ? obj : this.domObj;
			domObj.addClass('form-check-error').removeClass('form-check-wait').removeClass('form-check-succ').css('border', '2px solid red');
		var errorParentObj	= chkForm.domParent && typeof(eval('domObj'+chkForm.domParent)) ? eval('domObj'+chkForm.domParent) : domObj;
			if( typeof(errorParentObj) == 'object' )
			{
				errorParentObj.find('.checkError').html('<span class="red">'+msg+'</span>');
			}
			else
			{
				domObj.next('.checkError').html('<span class="red">'+msg+'</span>');
			}
	},
	showSucc: function(msg, obj)
	{
		var msg		= typeof(msg)=='undefined' ? '' : msg;
		var domObj	= typeof(obj)=='object' ? obj : this.domObj;
			domObj.addClass('form-check-succ').removeClass('form-check-wait').removeClass('form-check-error').css('border', '2px solid green');
		var errorParentObj	= chkForm.domParent && typeof(eval('domObj'+chkForm.domParent)) ? eval('domObj'+chkForm.domParent) : domObj;
			if( typeof(errorParentObj) == 'object' )
			{
				errorParentObj.find('.checkError').html('&nbsp;');
			}
			else
			{
				domObj.next('.checkError').html('&nbsp;');
			}
	},
	msgBox:function(status, content){
		alert('系统错误：'+content);
	}
});