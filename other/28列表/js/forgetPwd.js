// JavaScript Document
/*找回密码*/
function showWay(){
	if($('selWay').options[$('selWay').selectedIndex].value=='mail'){$('mailItem').setStyle('display','');$('mobItem').setStyle('display','none');}
	if($('selWay').options[$('selWay').selectedIndex].value=='mob'){$('mailItem').setStyle('display','none');$('mobItem').setStyle('display','');}
	}

ForgetPwd = {
    'emailLocalFun':function(){
        var _self = this;
        _self.allResult.emailLocal = true;
    },


    'telephoneLocalFun':function(){
        var _self = this;
        var telephoneFv = _self.telephoneF.get('value');
        _self.allResult.telephoneLocal = true;
    },

    'vcodeLocalFun':function(){
        var _self = this;
        var vcodeFv = _self.vcodeF.get('value');
        _self.allResult.vcodeLocal = true;

    },

	'validate':function(){
        console.log('1')
        this.emailLocalFun();
        if(!this.allResult.emailLocal){ this.lock = false; return;}
        console.log('2')
        this.telephoneLocalFun();
        if(!this.allResult.telephoneLocal){ this.lock = false; return;}
        console.log('5')
        this.vcodeLocalFun();
        if(!this.allResult.vcodeLocal){ this.lock = false; return;}
    },

    'showInfo':function(n,info){
		switch(n){
			case 0:
				$('tip').setProperties({'class':'wrongTip'});
				break;
			case 1:
				$('tip').setProperties({'class':'rightTip'});
		}
		$('tip').setStyle('display','block');
		$('tip').set('html',info);
    },

    'bindEvent':function(){
        var _self = this;
        _self.inputArr = $('forgetPwdForm').getElements('input');
        _self.tipsArr = $('forgetPwdForm').getElements('.tip');
        _self.infoArr = {
            'emailF':''
        };
        _self.emailF.getParent().getNext().removeClass('error').set('html',_self.infoArr['emailF']);
        _self.inputArr.each(function(item,index){
            item.addEvent('focus',function(){
                    this.removeClass('error');
                    if(_self.infoArr[this.id]){
                        this.getParent().getNext().removeClass('error').set('html',_self.infoArr[this.id]);
                    }else{
                        this.getParent().getNext().removeClass('error').set('html','');
                    }

                })
        });


        $('vimgF').addEvent('click',function(){
            _self.refresh();
        });
    },

    'refresh' : function(){
        $('vimgF').src = '/share/vimg?'+ new Date().getTime();

    },
    'getEls':function(){
        this.emailF = $('emailF');
        this.parentUnitF = $('parentUnitF');
        this.unitF = $('unitF');
        this.usernameF = $('usernameF');
        this.sexF1 = $('sexF1');
        this.sexF2 = $('sexF2');
        this.telephoneF = $('telephoneF');
        this.passwordF = $('passwordF');
        this.confirmPasF = $('confirmPasF');
        this.vcodeF = $('vcodeF');
    },

    'init':function(site_id){
        //alert(site_id);
        var _self = this;
        this.allResult = {
            'emailLocal':false,
            'emailAjax':false,
            'telephoneLocal':false,
            'telephoneAjax':false,
            'vcodeLocal':false
        };
        this.site_id = site_id;
        this.lock = false;

        this.getEls();
        this.bindEvent();
		
        $('forgetPwdForm').addEvent('submit',function(event){
            event.stop();
			//alert($('mailItem').getStyle('display'));
			if($('mailItem').getStyle('display') == 'block'){
				if($('emailF').get('value') == 0){
					_self.showInfo(0,'请填写电子邮箱地址！');
					$('emailF').addClass('error');
					return false;
				}else if($('emailF').get('value') != 0){
					var strm = $('emailF').get('value');
					var regm = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
					if (!strm.match(regm) && strm!=""){
						_self.showInfo(0,'邮箱地址格式错误或含有非法字符！');
						$('emailF').addClass('error');
						return false;
					}else if($('vcodeF').get('value') == 0){
						_self.showInfo(0,'验证码不能为空！');
						$('vcodeF').addClass('error');
					}else if($('vcodeF').get('value') != 0){
						var vcode = $('vcodeF').get('value').trim();
						if(!/^.{4}$/.test(vcode)){
							_self.showInfo(0,'验证码应为4位！');
							$('vcodeF').addClass('error');
							return false;
						}else{
							$('forgetPwdForm').submit();
						}
					}
				}
			}
			
			if($('mobItem').getStyle('display') == 'block'){
				if($('telephoneF').get('value') == 0){
					_self.showInfo(0,'请填写手机号码！');
					$('telephoneF').addClass('error');
					return false;
				}else if($('telephoneF').get('value') != 0){
					var telF = $('telephoneF').get('value');
					var regx=/^\d{11}$/;
					if(!regx.test(telF)){
						_self.showInfo(0,'手机号码格式错误！请输入类似格式13512345678');
						$('telephoneF').addClass('error');
						return false;
					}
					 else if($('vcodeF').get('value') == 0){
						_self.showInfo(0,'验证码不能为空！');
						$('vcodeF').addClass('error');
					}
					 else if($('vcodeF').get('value') != 0){
						var vcode = $('vcodeF').get('value').trim();
						if(!/^.{4}$/.test(vcode)){
							_self.showInfo(0,'验证码应为4位！');
							$('vcodeF').addClass('error');
							return false;
						}else{
							$('forgetPwdForm').submit();
						}
					}
				}
			}
			
            if(!_self.lock){
                _self.lock = true;
                //只有手工提交时进行submit
                _self.clickSubmit = true;
                for(var key in _self.allResult){
                    _self.allResult[key] == false;
                };
                _self.validate();
            };
        })
    }
};
