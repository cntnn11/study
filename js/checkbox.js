<!--
//*===========================================================================
//* (c)copyright 2000 liqwei
//* Email: liqwei(at)liqwei.com
//*  Site: http://www.liqwei.com/
//*===========================================================================
//* 功能：脚本代码；
//* 版本：v1.0；
//*===========================================================================


//===========================================================================【基本功能】
//功能：添加到收藏夹；
function addFavorite(url, name){
	var argLength = addFavorite.arguments.length;
	var theUrl = (argLength==0)?document.domain:url;
	var theName = (argLength==2)?name:document.title;
	var message = "您的浏览器不支持此设置，请手动设置！";
	try{
		if (document.all) { window.external.addFavorite(theUrl, theName);
		}else if (window.sidebar){ window.sidebar.addPanel(theName, theUrl, "");
		}else{ alert(message); }
	}catch(e){ alert(message); }
}
//功能：设置主页；
function setHomePage(url){
	var argLength = setHomePage.arguments.length;
	var theUrl = (argLength==0)?document.domain:url;
	try{
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(theUrl);
	}catch(e){ alert("您的浏览器不支持此设置，请手动设置！"); }
}
//功能：打印页面；
function doPrint(){ print(document); }
//功能：关闭窗口；
function doClose(){ self.opener=null; self.close(); }
//功能：推荐页面；
function doSelect(objHandle){
	try{objHandle.select();}catch(e){ alert("您的浏览器不支持此设置，请手动设置！"); }
}
//功能：复制指定内容到剪贴板中；
function doCopy(objHandle) {
	try{
		objHandle.select();
		window.clipboardData.clearData();
		window.clipboardData.setData("Text", objHandle.value);
		alert("复制成功！");
	}catch(e){ alert("您的浏览器不支持此设置，请手动设置！"); }
}
//===========================================================================【窗口】
//功能：在新窗口中显示一个文件，并指定窗口的宽度和高度；
function showFile(path, width, height){
	 var len = showFile.arguments.length;
	 var theWidth = (len>1)?width:800;
	 var theHeight = (len>2)?height:400;
	 
	if(path==null || path.length==0){
		alert("没有任何文件，请先上传！");
		return false;
	}else{
		openWindow(path, "showFileWindow", theWidth, theHeight, "scrollbars=1,status=1,resizable=1");
	}
}
//功能：新窗口自动居中；
function openWindow(url, name, width, height, style) {
  var left = (window.screen.availWidth-10-width)/2;
  var top = (window.screen.availHeight-30-height)/2;
  var win_style = "height="+height+",innerHeight="+height+",width="+width+",innerWidth="+width+",top="+top+",left="+left;
  if(style != null && style != ""){ win_style += "," + style; }
  window.open(url, name, win_style).focus();
}
//功能：窗口自动最大化；
function maxWindow(hWin){
	hWin.moveTo(0,0); hWin.resizeTo(screen.availWidth,screen.availHeight);
}
//功能：自动缩放图片在指定大小范围之内，针对 img 标签；
function zoomImage(imageHaddle, maxWidth, maxHeight){
	if(imageHaddle.width>0 && imageHaddle.height>0){
		var rate, isSelectWidth;
		if(maxWidth>0 && maxHeight>0){		
			isSelectWidth = (maxWidth/imageHaddle.width > maxHeight/imageHaddle.height);
			rate = isSelectWidth?(maxHeight/imageHaddle.height):(maxWidth/imageHaddle.width);			
		}else if(maxWidth < 0){
			isSelectWidth = false;
			rate = (maxHeight-imageHaddle.height)>0?1:maxHeight/imageHaddle.height;
		}else if(maxHeight < 0){
			isSelectWidth = false;
			rate = (maxWidth-imageHaddle.width)>0?1:maxWidth/imageHaddle.width;
		}
		if(rate<1){
			if(isSelectWidth){ imageHaddle.width = imageHaddle.width*rate;}
			else{ imageHaddle.height = imageHaddle.height*rate; }
		}
	}
}
//功能：获取页面查询字符串的值；
function getQueryString(name){
	var url = document.location.href;
	
	if(!document.queryString){
		document.queryString = new Object();
		
		var index = url.indexOf("?");
		if (index != -1){
			if(url.indexOf("#")>0){ url = url.substring(0, url.indexOf("#")); }
			var ary =  url.substring(index+1, url.length).split("&");;
			for (var i=0; i<ary.length; i++){
				document.queryString[ary[i].split("=")[0].toLowerCase()] = unescape(ary[i].split("=")[1]);
			}
		}
	}
	return document.queryString[name.toLowerCase()];
}
//===========================================================================【列表选择】
var className="";
//功能：控制页面的中，当鼠标悬浮时控制数据行的背景色显示；
function mouseOver(obj){ className = obj.className; obj.className = "over"; }
//功能：控制页面的中，当鼠标移开时控制数据行的背景色显示；
function mouseOut(obj){ obj.className = className; }
//功能：选择页面中所有的数据行；
function selectAll(controller, controlledItems, relatedItems){
	var isEnableRelatedControl = (selectAll.arguments.length==3);
	className = "selected";
	if(controlledItems.length>0){
		for(i=0; i<controlledItems.length; i++){
			controlledItems[i].checked = controller.checked;
			if(isEnableRelatedControl){
				selectIt(controlledItems[i], relatedItems);
			}else{
				selectIt(controlledItems[i]);
			}
		}
	}else{
		controlledItems.checked = controller.checked;
		if(isEnableRelatedControl){
			selectIt(controlledItems, relatedItems);
		}else{
			selectIt(controlledItems);	
		}
	}
}
//功能：选择页面中某一的数据行；
function selectIt(controller,controlledItems){
	var isEnableControl = (selectIt.arguments.length==2);
	var aryController = document.getElementsByName(controller.id);
	var aryDataRecord = document.getElementsByName("dataRecord");
	
	for(var i=0; i<aryController.length; i++){
		if(aryController[i]==controller){		
			if(controller.checked){
				className = "selected";
			}else{
				className = (i%2==1)?"single":"double";
			}
			if(aryDataRecord!=null && aryDataRecord.length>0){
				aryDataRecord[i].className = className;
			}
			if(isEnableControl){ 
				controlledItems[i].disabled=!controller.checked; 
			}
			return;
		}
	}
}
//===========================================================================【管理界面】
var isFullScreen = false;
var isMenuShow = true;
//功能：切换全屏显示；
function showFullScreen(){
	if(isFullScreen){
		isFullScreen = false;
		document.getElementById("adminHeader").style.display="";
		isMenuShow = false;
	}else{
		isFullScreen = true;	
		document.getElementById("adminHeader").style.display="none";
		isMenuShow = true;
	}
	showMenu();
}
//功能：切换菜单显示；
function showMenu(){
	if(isMenuShow){
		isMenuShow = false;
		document.getElementById("adminMenu").style.display="none";
		document.getElementById("adminMenuBorder").style.display="none";
	}else{
		isMenuShow = true;	
		document.getElementById("adminMenu").style.display="";
		document.getElementById("adminMenuBorder").style.display="";
	}
}
//功能：切换菜单项显示；
function showMenuBody(obj){
	var ary = document.getElementsByName("menuTitle");
	for(var i=0; i<ary.length; i++){
		if(ary[i]==obj){
			var aryBody = document.getElementsByName("menuBody");
			aryBody[i].style.display = (aryBody[i].style.display=="none")?"":"none";
			return;
		}
	}
}
//功能：刷新工作区域；
function refreshAdminMain(){try{top.adminMain.document.location.reload();}catch(e){}}
//功能：显示后台欢迎页面；
function showWelcome(path){
	var url = top.document.location.toString();
	var end = url.indexOf("/", 7);
	if(end>-1){
		url = url.substring(0, end);
	}else{
		url = url.substr(0);
	}
	
	var argLength = showWelcome.arguments.length;
	if(argLength==1){
		url += path;
	}else{
		url += "/admin/welcome.asp";	
	}
	top.adminMain.document.location= url;
}
//===========================================================================【字符操作】
//功能：获取随机数字；
function getRandomNumber(base, maxNumber){	return Math.floor(Math.random()*maxNumber-base+1)+base; }
// 功能：去除指定文本中的HTML标记；
function abstractText(html){
	if(isEmpty(html)) return "";
	html = trim(html.replace(/<[^>]*>/g,"").replace(/&nbsp;/ig," ")).replace(/&quot;/ig,"\"");
	html = html.replace(/&ldquo;/ig,"“").replace(/&rdquo;/ig,"”").replace(/&mdash;/ig,"—");
	html = html.replace(/&hellip;/ig,"…").replace(/&#160;/ig,"");
	return html;
}
// 功能：去除指定文本中的空白行；
function stripBlankLine(text){
	if(isEmpty(text)) return "";
	return text.replace(/\n[\s| ]*\r/g,"");
}
//===========================================================================【高级效验函数】
//功能：检验指定文本框输入是否在指定长度范围内；
function checkTextLength(objHandle, nameOfCheck, minLength, maxLength){
	var value = objHandle.value;
	if(minLength>0 && !isValid(value)){
		focusIt(objHandle);
		if(isEmpty(value))
			return error("“"+ nameOfCheck + "”不能为空！");
		else
			return error("“"+ nameOfCheck + "”中包含非法字符('或\"或&)！");
	}
	if(!isLengthBetween(value, minLength, maxLength)){
		focusIt(objHandle);
		return errorLengthBetween(nameOfCheck, minLength, maxLength);
	}
	return true;
}
//功能：检验指定文本框输入是否为数字；
function checkNumberLength(objHandle, nameOfCheck, minLength, maxLength){
	var value = objHandle.value;
	if(minLength>0 && !isNumber(value)){
		focusIt(objHandle);
		return error("“"+ nameOfCheck + "”的格式错误！");
	}
	if(!isLengthBetween(value, minLength, maxLength)){
		focusIt(objHandle);
		return errorLengthBetween(nameOfCheck, minLength, maxLength);
	}
	return true;
}
//功能：检验指定文本框输入是否在指定数值范围内；
function checkValue(objHandle, nameOfCheck, minValue, maxValue){
	var value = objHandle.value;
	if(!isNumber(value)){
		focusIt(objHandle);
		return error("“"+ nameOfCheck + "”的格式错误！");	
	}
	if(!isValueBetween(value, minValue, maxValue)){
		focusIt(objHandle);
		return errorValueBetween(nameOfCheck, minValue, maxValue);
	}
	return true;
}
//功能：检验指定文本框输入是否相同；
function checkSame(objHandle1, objHandle2, nameOfCheck){
	var value1 = objHandle1.value;
	var value2 = objHandle2.value;
	
	if(!isSame(value1, value2)){
		focusIt(objHandle1);
		return error("两次“"+ nameOfCheck + "”输入不一致！");
	}
	return true;
}
//功能：检验指定文本框输入是否为邮件地址；
function checkEmail(objHandle, nameOfCheck, minLength, maxLength){
	var email = objHandle;
	if(!isLengthBetween(email.value, minLength, maxLength)){
		focusIt(email);
		return errorLengthBetween(nameOfCheck, minLength, maxLength);
	}
	if(minLength>0 && !isEmail(email.value)){
		focusIt(email);
		return error("“"+ nameOfCheck + "”的格式错误！");
	}
	return true;
}
//功能：检验指定文本框输入是否为Url地址；
function checkUrl(objHandle, nameOfCheck, minLength, maxLength){
	var url = objHandle;
	if(!isLengthBetween(url.value, minLength, maxLength)){
		focusIt(url);
		return errorLengthBetween(nameOfCheck, minLength, maxLength);
	}
	if(minLength>0 && !isUrl(url.value)){
		focusIt(url);
		return error("“"+ nameOfCheck + "”的格式错误！");
	}
	return true;
}

//功能：检验指定文本框输入是否为图片地址；
function checkImage(objHandle, nameOfCheck, minLength, maxLength){	
	var url = objHandle;
	if(!isLengthBetween(url.value, minLength, maxLength)){
		focusIt(url);
		return errorLengthBetween(nameOfCheck, minLength, maxLength);
	}
	if(!isEmpty(url.value)&&!isImage(url.value)){
		focusIt(url);
		return error("“"+ nameOfCheck + "”的格式错误！");
	}
	return true;
}
//功能：检验指定文本框输入是否为电话号码；
function checkPhone(objHaddle, nameOfCheck, minLength, maxLength){
	var phoneCode = objHaddle;
	if(!isLengthBetween(phoneCode.value, minLength, maxLength)){
		focusIt(phoneCode);
		return errorLengthBetween(nameOfCheck, minLength, maxLength);
	}
	if(minLength>0 && !isPhone(phoneCode.value)){
		focusIt(phoneCode);
		return error("“"+ nameOfCheck + "”的格式错误！");
	}
	return true;
}
//功能：检验指定文本框输入是否为手机号码；
function checkMobile(objHaddle, nameOfCheck, minLength, maxLength){
	var mobileCode = objHaddle;
	if(!isLengthBetween(mobileCode.value, minLength, maxLength)){
		focusIt(mobileCode);
		return errorLengthBetween(nameOfCheck, minLength, maxLength);
	}
	if(minLength>0 && !isMobile(mobileCode.value)){
		focusIt(mobileCode);
		return error("“"+ nameOfCheck + "”的格式错误！");
	}
	return true;
}
//功能：检验指定文本框输入是否为邮政号码；
function checkPostCode(objHaddle, nameOfCheck, minLength, maxLength){
	var postCode = objHaddle;
	if(!isLengthBetween(postCode.value, minLength, maxLength)){
		focusIt(postCode);
		return errorLengthBetween(nameOfCheck, minLength, maxLength);
	}
	if(minLength>0 && !isPostCode(postCode.value)){
		focusIt(postCode);
		return error("“"+ nameOfCheck + "”的格式错误！");
	}
	return true;	
}
//功能：检验是否选择了指定的单选框；
function checkSelect(objHandle, nameOfCheck){
	if(!isSelect(objHandle)){
		focusIt(objHandle);
		return error("请选择“"+ nameOfCheck + "”！");
	}
	return true;
}
//功能：检验是否选择了指定数量的复选框；
function checkSelectCount(objHandle, nameOfCheck, minCount, maxCount){
	if(!isSelectBetween(objHandle, minCount, maxCount)){
		focusIt(objHandle);
		return errorCountBetween(nameOfCheck, minCount, maxCount);
	}
	return true;
}
//功能：检验是否选择下拉列表框；
function checkList(objHandle, nameOfCheck, errorValue){
	var list = objHandle;
	if(isEmpty(list.value)){
		focusIt(list);
		return error("请选择“"+ nameOfCheck + "”！");
	}
	if(list.multiple){  // 多选情况；
		with(list){
			for(var i=0; i<length; i++){
				if(options[i].selected)
					return true;
			}
		}
		focusIt(list);
		return error("请选择“"+ nameOfCheck + "”！");
	}else if(isSame(list.value, errorValue)){  // 单选情况；
		focusIt(list);
		return error("请选择“"+ nameOfCheck + "”！");
	}
	return true;
}
//功能：检验是否选择了指定数量的下拉列表框选项（针对，添加新条目的情况）；
function checkListCount(objHandle, nameOfCheck, minCount, maxCount){
	var list = objHandle;
	if(!isValueBetween(list.length, minCount, maxCount)){
		focusIt(list);
		return errorCountBetween(nameOfCheck, minCount, maxCount);
	}
	return true;
}
//功能：检验是否选择了指定数量的下拉列表框选项（针对选择已有条目的情况）；
function checkListSelectedCount(objHandle, nameOfCheck, minCount, maxCount){
	var list = objHandle;
	if(isEmpty(list.value)){
		focusIt(list);
		return error("请选择“"+ nameOfCheck + "”！");
	}
	if(list.multiple){  // 多选情况；
		var selectedCount = 0;
		with(list){
			for(var i=0; i<length; i++){
				if(options[i].selected)
					selectedCount ++;
			}
		}
		if(!isValueBetween(selectedCount, minCount, maxCount)){
			focusIt(list);
			return errorCountBetween(nameOfCheck, minCount, maxCount);
		}
	}
	return true;
}
//功能：将指定内容和值插入到列表中，过滤重复选项；
function insertItemIntoList(objHandle, text, value){
	var length = objHandle.length;
	for(var i=0; i<length; i++){
		if(objHandle.options[i].value==value) return;
	}
	objHandle.options[length] = new Option(text, value);
}
//功能：从列表中删除所有选中的选项；
function deleteSelectedItemInList(objHandle){
	for(var i=0; i<objHandle.length; i++){
		if(objHandle.options[i].selected){
			objHandle.remove(i); 
			i=-1;
		}
	}
}
//功能：从列表中删除所有选项；
function deleteAllItemInList(objHandle){
	while(objHandle.length>0){
		objHandle.remove(0);
	}
}
//功能：在两个列表间复制所有被选中的选项，过滤重复选项，支持级联父类选项标签提取；
function copySelectedItemBetweenList(objHandleSrc, errorValue, objHandleAim){
	var arguments = copySelectedItemBetweenList.arguments;
	var length = arguments.length;
	var isEnableRelationParent = (length>3);
	
	for(var i=0; i<objHandleSrc.length; i++){
		var theOption = objHandleSrc.options[i];
		if(theOption.selected){
			if(theOption.value==errorValue){
				break;
			}
			
			var isExist = false;
			for(var j=0; j<objHandleAim.length; j++){
				if(objHandleAim.options[j].value==theOption.value){
					isExist = true;
					break;
				}
			}
			if(!isExist){
				if(isEnableRelationParent){
					var text = "";
					for(var j=3; j<length; j++){
						var obj = arguments[j];
						if(j==3){
							text=obj.options[obj.selectedIndex].text;
						}else{
							text+=" / "+obj.options[obj.selectedIndex].text;
						}
					}
					text += " / " + theOption.text;
					objHandleAim.options[objHandleAim.length] = new Option(text, theOption.value);
				}else{
					objHandleAim.options[objHandleAim.length] = new Option(theOption.text, theOption.value);
				}
			}
		}
	}	
}
//功能：在两个列表间复制所有选项，过滤重复选项；
function copyAllItemBetweenList(objHandleSrc, objHandleAim){
	for(var i=0; i<objHandleSrc.length; i++){
		var theOption = objHandleSrc.options[i];
		var isExist = false;
		for(var j=0; j<objHandleAim.length; j++){
			if(objHandleAim.options[j].value==theOption.value){
				isExist = true; 
				break;
			}
		}
		if(!isExist)
			objHandleAim.options[objHandleAim.length] = new Option(theOption.text, theOption.value);
	}
}
//功能：在两个列表间移动所有被选中的选项；
function moveSelectedItemBetweenList(objHandleSrc, objHandleAim){
	for(var i=0; i<objHandleSrc.length; i++){
		var theOption = objHandleSrc.options[i];
		if(theOption.selected){
			objHandleAim.options[objHandleAim.length] = new Option(theOption.text, theOption.value);
			objHandleSrc.remove(i);
			i=-1;
		}
	}
}
//功能：在两个列表间移动所有选项；
function moveAllItemBetweenList(objHandleSrc, objHandleAim){
	for(var i=0; i<objHandleSrc.length; i++){
		var theOption = objHandleSrc.options[i];
		objHandleAim.options[objHandleAim.length] = new Option(theOption.text, theOption.value);
		objHandleSrc.remove(i);
		i=-1;
	}
}
//功能：将列表中的所有选项都选中；
function selectAllItemInList(objHandle){
	for(var i=0; i<objHandle.length; i++){
		objHandle.options[i].selected = true;
	}
}
//===========================================================================【提示函数】
function deleteSelected(){
	if(!onDelete()) return false;
	return true;
}
//功能：确认操作相关函数；
function onDelete(){
	return confirm("系统提示：\n\n所选数据一旦被删除将无法恢复，确实要删除？\t\n\n（删除请点击“确定”，否则点击“取消”）\t");
}
//功能：提交表单前确认；
function onSubmit(){
	return confirm("系统提示：\n\n输入数据一旦被提交将无法恢复，确实要提交？\t\n\n（提交请点击“确定”，否则点击“取消”）\t");
}
//功能：重置表单前确认；
function onReset(){
	return confirm("系统提示：\n\n输入数据一旦被重设将无法恢复，确实要重设？\t\n\n（重设请点击“确定”，否则点击“取消”）\t");
}
//功能：onMouseOver 事件下，聚焦指定对象；
function onOver(obj){
	try{ obj.focus(); }catch(e){}
}
//功能：聚焦指定对象；
function focusIt(obj){
	try{ obj.focus(); }catch(e){}
}
//功能：提示错误信息，并返回“假”；
function error(msg){
	alert("错误提示：\n\n"+ msg +"\t");
	return false;
}
//===========================================================================【基础校验函数】
//功能：检测数据是否在指定的长度范围内(包含边界值)，当为 -1 时忽略边界值；
function isLengthBetween(value, minLength, maxLength){
	value = trim(value);
	if(minLength<0 && maxLength<0){
		return true;
	}else if(minLength<0){
		return (value.length<(maxLength+1));
	}else if(maxLength<0){
		return (value.length>(minLength-1));
	}else{
		return (value.length>(minLength-1) && value.length<(maxLength+1));
	}
}
//功能：检测数据是否在指定的数据范围内(包含边界值),当为 -1 时忽略边界值；
function isValueBetween(value, minValue, maxValue){
	if(!isNumber(value)) return false;
	var temp = parseInt(value);
	if(minValue<0 && maxValue<0){
		return true;
	}else if(minValue<0){
		return (value<(maxValue+1));
	}else if(maxValue<0){
		return (value>(minValue-1));
	}else{
		return (temp>(minValue-1) && temp<(maxValue+1));
	}
}
//功能：检测是否选择了指定对象，针对 checkbox，radio 控件；
function isSelect(obj){
	if(obj==null){ return false; }
	var checkedFlag = false;
	if(obj.length != "undifine" && obj.length>0){
		for(var i=0; i<obj.length; i++){
			if(obj[i].checked){
				checkedFlag = true;
				break;
			}
		}
	}else{
		if(obj.checked){ checkedFlag = true; }
	}
	
	return checkedFlag;
}
//功能：检测是否选择了指定数目的对象，针对 checkbox，radio 控件；
function isSelectBetween(obj, minCount, maxCount){
	if(obj==null){ return false; }
	var selectedCount = 0;
	if(obj.length>0){
		for(var i=0; i<obj.length; i++){
			if(obj[i].checked){
				selectedCount ++;
			}
		}
	}else{
		if(obj.checked){ selectedCount ++; }
	}
	if(minCount<0)
		return (selectedCount<(maxCount+1));
	else if(maxCount<0)
		return (selectedCount>(minCount-1));
	else
		return (selectedCount>(minCount-1) && selectedCount<(maxCount+1));
}
//功能：根据不同的长度返回错误信息；
function errorLengthBetween(nameOfCheck, minLength, maxLength){
	if(minLength<0)
		return error("“"+ nameOfCheck + "”的字数长度最多不能超过："+ maxLength +" 个字符！");
	else if(maxLength<0)
		return error("“"+ nameOfCheck + "”的字数长度最低不能少于："+ maxLength +" 个字符！");
	else if(minLength == maxLength)	
		return error("“"+ nameOfCheck + "”的字数长度必须为："+ minLength +" 个字符！");
	else
		return error("“"+ nameOfCheck + "”的字数长度范围为："+ minLength +"～"+ maxLength +"！");
}
//功能：根据不同的数值返回错误信息；
function errorValueBetween(nameOfCheck, minValue, maxValue){
	if(minValue<0)
		return error("“"+ nameOfCheck + "”的数值最大不能超过："+ maxValue +" ！");
	else if(maxValue<0)
		return error("“"+ nameOfCheck + "”的数值最小不能低于："+ minValue +" ！");
	else if(minValue == maxValue)
		return error("“"+ nameOfCheck + "”的数值只能是："+ minValue +" ！");
	else
		return error("“"+ nameOfCheck + "”的数值范围为："+ minValue +"～"+ maxValue +"！");
}
//功能：根据不同的个数返回错误信息；
function errorCountBetween(nameOfCheck, minCount, maxCount){
	if(minCount<0)
		return error("至多选择 "+ minCount +" 个“"+ nameOfCheck +"”！");
	else if(maxCount<0)
		return error("至少选择 "+ minCount +" 个“"+ nameOfCheck +"”！");
	else if(minCount == maxCount)
		return error("只能选择 "+ minCount +" 个“"+ nameOfCheck +"”！");		
	else
		return error("“"+ nameOfCheck + "”的选择范围为："+ minCount +"～"+ maxCount +" 个！");
}
//===========================================================================【获取指定对象】
//功能：获取指定名称的控件对象；
function getById(fieldName){ return document.getElementById(fieldName); }
function getByPid(fieldName){ return ''; }
//功能：获取指定名称的控件对象数组；
function getByName(fieldName){ return document.getElementsByName(fieldName); }
//功能：获取指定表单，指定名称的控件对象或对象数组；
function getByForm(formName, fieldName){ return eval("document."+ formName +"."+ fieldName); }
//功能：获取列表的文字；
function getText(objHaddle){ return objHaddle.options[objHaddle.selectedIndex].text; }
//功能：获取指定控件对象的值；
function getValue(objHaddle){ return objHaddle.value; }
//功能：获取指定的单选框控件对象的值；
function getValueByRadio(objHaddle){
	for(var i=0; i<objHaddle.length; i++){
		if(objHaddle[i].checked) return objHaddle[i].value;
	}
}
//功能：设置单选框的值；
function setValueByRadio(objHaddle, value){
	for(var i=0; i<objHaddle.length; i++) {
		if (objHaddle[i].value==value) { objHaddle[i].checked = true; }
	}
}
//功能：获取指定的多选框控件对象的值；
function getValueByCheck(objHaddle, splitor){
	var value = new Array();
	for(var i=0,j=0; i<objHaddle.length; i++){
		if(objHaddle[i].checked){ value[j++]=objHaddle[i].value; }
	}
	return value.join(splitor);
}
//功能：设置多选框的值；
function setValueByCheck(objHaddle, value, splitor){
	var aryValue = value.split(splitor);
	for(var i=0; i<objHaddle.length; i++){
		for(var j=0; j<aryValue.length; j++){
			if(objHaddle[i].value==aryValue[j]){ objHaddle[i].checked=true; }
		}
	}
}
//===========================================================================【底层校验函数】
// 功能：检测指定值是否为空；
function isEmpty(value){ return (value == null)||(trim(value).length == 0); }
// 功能：检测两个值是否相同；
function isSame(value1, value2){ return (trim(value1) == trim(value2)); }
// 功能：去处空格(包括空格，tab，form feed，换行符，等价于[ \f\n\r\t\v])；
function trim(value){
	if(value==null) return null;
	return value.replace(/(^\s*)|(\s*$)/g,"");
}
//功能：检测指定值是否包含非法字符('或")；
function isValid(input){
	if(isEmpty(input)) return false;
	if(input.indexOf("\"")!=-1) return false;
	if(input.indexOf("'")!=-1) return false;
	return true;
}
//功能：检测指定值是否为字母，不区分大小写；
function isLetter(input){
	return (new RegExp("^[a-z]+$","gi")).test(input);
}
//功能：检测指定值是否为数字；
function isNumber(input){
	return (new RegExp("[0-9]+$","gi")).test(input);
}
//功能：检测指定值是否为汉字；
function isChinese(input){
	return (new RegExp("[\u4e00-\u9fa5]","gi")).test(input);
}
//功能：检测指定值是否为合法 IP 地址；
function isIP(input){
	return (new RegExp("\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}","gi")).test(input);
}
//功能：检测指定值是否为合法 Email 地址；
function isEmail(input){
	return (new RegExp("[(\\w-)+\\.]+@{1}[(\\w-)+\\.]+[a-z]{2,3}$","gi")).test(input);
}
//功能：检测指定值是否为合法 URL 地址；
function isUrl(input){
	return (new RegExp("(http://)?[(\\w-)+\\./]+[a-z]{2,3}[/(\\w-\\.)+]*","gi")).test(input);
}
//功能：检测指定值是否为合法图片地址；
function isImage(input){
	return (new RegExp("/(http://)?[(\\w-)+\\./]+[a-z]{2,3}[/(\\w-\\.)+]*[^/:\*\?<>\|]+\.(jpg|jpeg|gif|png|bmp)$","gi")).test(input);
}
//功能：检测是否为电话号码，例如：0311-82261131；
function isPhone(input){
	return (new RegExp("(\\d{3,4}-\\d{7,8})","gi")).test(input);
}
//功能：检测是否为电话号码，例如：13522487523；
function isMobile(input){
	return (new RegExp("^1(([3][0-9])|([5][0136789])|([8][056789]))[0-9]{8}$","gi")).test(input);
}
//功能：检测是否为邮政编码；
function isPostCode(input){
	return (new RegExp("\\d{6}","gi")).test(input);
}
//功能：检测输入是否为一个合法的QQ号码，格式：5 位数字以上数字，腾讯QQ号从10000开始；
function isQQCode(input){
	return (new RegExp("[1-9][0-9]{4,}","gi")).test(input);
}
//功能：检测输入是否为一个合法的身份证号码，格式：15位或18位数字或x；
function isIDCode(input){
	return (new RegExp("[0-9x]{15}|[0-9x]{18}","gi")).test(input);
}
//功能：检测输入是否为一个合法的身份证号码，格式：15位或18位数字或x；
function isValidName(input){
	return (new RegExp("^[a-z][a-z0-9_]{5,19}","gi")).test(input);
}
-->
getAllChildCheckbox('pid_10');
function getAllChildCheckbox(pid)
{
	var inputs	= [];
		inputs	= document.getElementsByTagName("input");
	var checkboxArray	= [];
	for( var i = 0 in inputs )
	{
		var obj	= inputs[i];
		if( typeof(obj)=='object' && obj.getAttribute('type')=='checkbox' && obj.getAttribute('pid')==pid )
		{
			checkboxArray.push(obj);
		}
	}
	return checkboxArray;
}
