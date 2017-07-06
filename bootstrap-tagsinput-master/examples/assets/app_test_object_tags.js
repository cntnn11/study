var elt = $('.example_objects_as_tags > > input');
elt.tagsinput({
	itemValue: 'value',
	itemText: 'display',
	typeaheadjs: [
		{
			minLength: 1,
			highlight: true
		},
		{
			displayKey: 'display',
			source: function (query, process) {
				var parameter = {query: query};
				$.post('http://test.study.com/bootstrap-tagsinput-master/examples/data.php', parameter, function (data) {
					process(data);
				}, 'json');
			}
		}
	],
	freeInput: true,
	onTagExists: function(item, $tag) {
		return false;
	},
	width: 'auto',
	allowDuplicates: false,
	trimValue: true,
	confirmKeys: [32],
	maxChars: 8,
	maxTags: 2,
	tagClass: 'course-tag'
});
elt.on('itemAddedOnInit', function(event){
	alert('1');
});

// 添加项目对结果值进行处理
elt.on('itemAdded', function(event) {

	var val	= elt.val();
	if( !val )
	{
		return;
	}

	var tagsNum	= val.split(",").length;
	if( tagsNum == event.options.maxTags )
	{
		elt.attr('placeholder', '最大值了，不能再写了！');
		//$('input').tagsinput('destroy');
	}
	else
	{
		elt.attr('placeholder', '填写课程ID');
	}

	if( typeof(event.item.value) == 'undefined' || event.item.value.length <= 0 )
	{
		elt.tagsinput( 'remove', event.item );
	}
});


$(".twitter-typeahead").css('display', 'inline');

// 获取input结果值
$('#btn').click(function(){
	$('#val').html( elt.val() );
});
