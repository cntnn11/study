
/**************************************************
 * 手风琴效果类
 **************************************************/
var AccControl = function(PanelID/*效果控件ID*/){
	this.PanelID = PanelID;
	this.setEvent();//设置事件
};

//获取下一个html对象
AccControl.getNextElement = function(elem){
	var _elem = null;
	if (elem.nextSibling)
	{
		if (elem.nextSibling.nodeType == 3)
		{
			_elem = elem.nextSibling.nextSibling;
		}
		else
		{
			_elem = elem.nextSibling;
		}
	}
	return _elem;
};

//获取前一个html对象
AccControl.getPrevElement = function(elem){
	var _elem = null;
	if (elem.previousSibling)
	{
		if (elem.previousSibling.nodeType == 3)
		{
			_elem = elem.previousSibling.previousSibling;
		}
		else
		{
			_elem = elem.previousSibling;
		}
	}
	return _elem;
};

//设置事件
AccControl.prototype.setEvent = function(){
	var self = this;
	var h3 = document.getElementById(this.PanelID).getElementsByTagName("h3");
	var div = document.getElementById(this.PanelID).getElementsByTagName("div");
    var li = document.getElementById(this.PanelID).getElementsByTagName("li");
	var h2 = document.getElementById("zeropane").getElementsByTagName("h2");
	
	
	for(var i=0;i<h3.length-1;i++)
	{
		h3[i].onclick = function(){
			self.show(this);
		};		
		var IeHeight = div[i].offsetHeight - 10;
		div[i].style.height = document.all? IeHeight +"px" : div[i].offsetHeight +"px";
		div[i].style.paddingTop = document.all? "15px" : "0px";
		div[i].style.display = "none";
		div[div.length-1].style.display = "";
	
	};
	
	
};

//显示切换
AccControl.prototype.show = function(obj){
	//获取对象
	var h3 = document.getElementById(this.PanelID).getElementsByTagName("h3");
	var div = document.getElementById(this.PanelID).getElementsByTagName("div");
	var li = document.getElementById(this.PanelID).getElementsByTagName("li");
	var h2 = document.getElementById("zeropane").getElementsByTagName("h2");
	
	
	var temp = function(){
		//复位元素状态
		for(var i=0;i<div.length;i++)
		{
			div[i].style.display = "none";
			h3[i].className = "gray";
		}
		
	
			
			
		//展开底部显示样式
		var cn = AccControl.getNextElement(obj);
		cn = AccControl.getNextElement(cn).className;
		h3[h3.length-1].style.display = (cn == "deep-bottom")? "" : "none";

		h3[0].className = "gray-top";	//顶部显示样式
		h3[h3.length-2].className = "gray-bottom";	//底部显示样式
	
		
		//顶部展开显示样式
		obj.className = (AccControl.getPrevElement(obj) == null)? "deep-top" : "deep";
		
		//渐变显示
		AccControl.toggle(AccControl.getNextElement(obj) ,"show");
		
	};
	setTimeout(temp ,400);
};

//缓慢显示层
AccControl.toggle = function(elem ,cmd){
	elem.style.display = "";
	elem.style.filter = "alpha(opacity=0)";
	var b = 1;
	var add = function(){
		if(b >= 100 || b <= 0)
		{
			clearInterval(tid);
			return false;
		}
		b = (cmd == "show")? (b + 2) : (b - 2);
		elem.style.opacity = b/100;
		elem.style.filter = "alpha(opacity="+ b +");";
	};

	var tid = setInterval(add ,10);
};