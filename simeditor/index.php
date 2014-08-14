<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="./styles/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="./styles/simditor.css" />
<link rel="stylesheet" type="text/css" href="./styles/simditor-emoji.css" />
<script type="text/javascript" src="./scripts/js/jquery.min.js"></script>

<!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.1/styles/default.min.css"> -->
<link rel="stylesheet" type="text/css" href="http://highlightjs.org/static/styles/monokai_sublime.css">
</head>
<body>
<?php
if( isset($_POST) && $_POST['editor'] )
{
	echo '<pre>';
	var_dump($_POST);
	echo '</pre>';
}

?>
<p>
	<label>提交的编辑器内容：</label>
	<hr/>
	<div id="default_val"><?php echo $_POST['editor']; ?></div>
</p>
<p>
	<label>测试代码渲染：</label>
	<hr/>
	<div>
		<pre class="lang-php" data-lang="php"><code class="lang-php" data-lang="php">&lt;?php
echo 'hello world!';</code></pre>
	</div>
</p>
<hr/>
<form action="" method="post">
	<p><textarea name="editor" id="editor" placeholder="这里输入内容" ><?php echo $_POST['editor']; ?></textarea></p>
	<p>
		<input type="button" id="getvalue" value="获取值" />&nbsp;&nbsp;
		<input type="submit" value="提交" />
	</p>
</form>


<script type="text/javascript" src="./scripts/js/simditor-all.js"></script>
<script type="text/javascript" src="./scripts/js/simditor-emoji.js"></script>
<script type="text/javascript">

var sm_toolbar	= ['emoji', 'title', 'bold', 'italic', 'underline', 'strikethrough', 'ol', 'ul', 'blockquote', 'code', 'table', 'link', 'image', 'hr', 'indent', 'outdent'];
var editor = new Simditor({
	textarea: $('#editor'),
	toolbar: sm_toolbar,
	emoji: {
		imagePath: 'images/emoji'
	},
	pasteImage: true
	/*upload:{
		url: '',
		params: null,
		connectionCount: 3,
		leaveConfirm: '正在上传文件，如果离开上传会自动取消'
	}*/
});
var default_val	= $('#default_val').html();
editor.setValue(default_val);
$(function(){
	$('#getvalue').click(function(){
		console.log( editor.getValue() );
	});
});

function formatCode( )
{
	$('pre').each(function(i, e){
console.log(e);
		var class_name	= $(this).attr('class');
		var data_lang	= $(this).attr('data-lang');
		var code_html	= $(this).find('code').html();
		if( code_html==undefined && class_name && data_lang && class_name.indexOf('lang-') >= 0 )
		{
			var source_code	= $(this).html();
			if( $(this).parent().attr('class') != 'simditor-body' )
			{
				$(this).html( '<code class="'+class_name+'" data-lang="'+data_lang+'" >'+source_code+'</code>' );
			}
		}
	});
}

</script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.1/highlight.min.js"></script>
<script>
formatCode();
hljs.initHighlightingOnLoad();
</script>




</body>

