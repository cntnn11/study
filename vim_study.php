插入：
	i: 大家都知道
	A: 在行末添加新文本
	I: 在行首添加新文本
移动光标：
	h: 向左移动一个字符
	j: 移动到下一行
	k: 移动到上一行
	l: 向右移动一个字符
	$: 移动到行尾
	0: 移动到行首

	H: 移动到屏幕顶端
	M: 移动到屏幕中间
	L: 移动到屏幕底端

定位：
	:set nu -> 显示行号
	:set nonu -> 取消行号显示

	:gg -> 到第一行
	:G  -> 到最后一行

	:num -> 到指定第num行

删除：
	:x -> 删除当前字符(类似win下的delete键)
	nx: 删除从当前光标开始n个字符
	dd: 删除所在行
	dG: 删除从光标所在行到最后一行的内容（慎用！）
	D:  删除光标所处位置到行尾内容
	:n1,n2d -> 删除第1行到第2行的内容
复制和剪切
	yy / Y: 复制某行内容
	nyy / nY: 复制当前某行往下n行的内容
	dd: 剪切当前行
	ndd: 剪切当前行开始往下n行
	p: 粘贴数据到当前行

搜索：
	:/%s -> 搜索…… 按n查找下一个
	:%s/old/new/g -> 全文指定替换字符 exp: :%s/i/L/g 全文替换 
	:n1,n2s/old/new/g -> 在n1行到n2行之间进行查找替换  exp:  :47,50s/k/K/g



iKKKsfjKKKlasf;
KKKjsdfasfhlaKKKsdf
jKKKashlfKKKKKKsafKKKKKKsdfsfl
aaslKKKfhasd
jkdl
this is content;
hello world!
set put pull push yr bb cc dd ee ff gg ii kk ll dd aa dd cc ss

