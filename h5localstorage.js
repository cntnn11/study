// 操作html5本地存储
var h5db	= {
	init: function(){
		if( !window.localStorage )
		{
			stat.isH5Local	= false;
		}
	},
	add:function( k, val ){
		var k	= k ? k : '';
		var val	= val ? val : '';
		localStorage[k]	= val;
	},
	update:function( k, val ){
		var k	= k ? k : '';
		var val	= val ? val : '';
		localStorage[k]	= val;
	},
	del:function(k){
		if( k )
		{
			localStorage.removeItem(k);
		}
	},
	get:function(k){
		if( k )
		{
			var res	= localStorage.getItem( k );
			return res;
		}
		else
		{
			return '';
		}
	}
};
