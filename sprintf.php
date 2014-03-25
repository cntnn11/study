<?php
 /**
  *        sprintf()函数使用
  *        @date 2012-12-17
  *        @author cntnn11
  */
  /**
  *        手册定义：函数把格式化的字符串写写入一个变量中。
  *        他的可识别的格式
  *            %% - 返回百分比符号
  *            %b - 二进制数
  *            %c - 依照 ASCII 值的字符
  *            %d - 带符号十进制数
  *            %e - 科学计数法（比如 1.5e+3）
  *            %u - 无符号十进制数
  *            %f - 浮点数(local settings aware)
  *            %F - 浮点数(not local settings aware)
  *            %o - 八进制数
  *            %s - 字符串
  *            %x - 十六进制数（小写字母）
  *            %X - 十六进制数（大写字母）
  *        sprintf($str, arg1, arg2, arg3 ...);
 */
 
 /**
 *    1.    %%
 *        把%%替换成%
 */
 $testStr    = '测试下%%这个参数。会被替换成什么呢';
 echo sprintf($testStr),'<br/>';
 //-> 测试下%这个参数。会被替换成什么呢;
 //只剩下一个%了
 //看来还真的只是返回一个‘%’。但是实际应用中该怎么用呢？
 //我也不知道~
 echo '<br/><hr/><br/>';
 /**
 *    2.    %b 
 *        该参数只能替换整型数据。如果是浮点型，那么他只会取整数部分。小数点后边的会忽略
 *        如果是一个非整型数据，那么返回 0 
 */
 $testStr    = '听说%b会替换成二进制数，真的吗？';
 $arg        = '10';
 echo sprintf($testStr, $arg),'<br/>';
 //-> 1010;    $arg=10;    真的替换了！
 //-> 101;    $arg=4.5
 //-> 0;        $arg=str/bool...
 echo '<br/><hr/><br/>';
 
 /**
 *    3.    %c 返回字符编码的ASCII码
 *        TIP：[他不是返回ASCII码]
 *        $arg接受一个int传入即ASCII的数字值，然后返回该值对应的字符
 */
 $testStr    = '我们来测试下 %c : 试试看能返回ASCII码吗';
 $arg    = '122';
 echo sprintf($testStr, $arg);
 //-> A;    $arg=65;
 //-> z; $arg=122
 echo '<br/><hr/><br/>';
 /**
  *    4. %d 将一段字符里的%d替换成int型
  *        TIP：这里可以是任意一个int整型。
  *            如果是一个浮点数据，那么只会替换整数部分
  *            如果是非数字的，那么会替换成0
  */
 $testStr    = "这是一个ID，ID号是%d，";
 $arg        = '-4';
 echo sprintf($testStr, $arg);
 //-> 4;    $arg=4.5
 //-> 0; $arg=[a-zA-Z\s];
 echo '<br/><hr/><br/>';
 
 /**
  *    5.    %e 科学计数法
  *        TIP:将一段很长很长的int整型数据以科学计数法的形式呈现
  *            同%d，该函数同样会忽略掉小数点后面的，任何非数值数据替换成0
 */
 $testStr    = "我很长，有N多位。。。 %e";
 $arg        = '46498464654864564642449463699789789313';
 echo sprintf($testStr, $arg);
 //-> 4.649846e+14;    $arg=464984646548645.64642449463699789789313
 //-> 0.000000e+0; $arg=asdfasdf;
 echo '<br/><hr/><br/>';
 
 /**
  *    5.    %u - 无符号十进制数
  *        不明白。。。如果有是负数，他的值不知道是啥值
 */
 $testStr    = "我是无符号的十进制数。。。 %u";
 $arg        = '456';
 echo sprintf($testStr, $arg);
 echo '<br/><hr/><br/>';
 
 /**
  *    6.    %f - 浮点数(local settings aware)
  *            难道和%d是相反的？
  *                这个会返回一个浮点数，并且小数点后面只有固定的6位
  *                字符串同样为 0 ；
 */
 $testStr    = "和那个d有啥区别呢？%f";
 $arg        = '456.235645';
 echo sprintf($testStr, $arg);
 echo '<br/><hr/><br/>';
 
 /**
  *    7.    %F - 浮点数(not local settings aware)
  *        难道和%f是相反的？怎么和小f没区别？不会吧
  */
 $testStr    = "和那个小写的f有啥区别呢？%F";
 $arg        = '12312316.46898';
 echo sprintf($testStr, $arg);
 echo '<br/><hr/><br/>';
 
 /**
  *    8.    %o - 八进制数
  *        同%d一样。只不过参数传入一个八进制数值
  */
 $testStr    = "将八进制数替换成十进制的 %o";
 $arg        = '8';
 echo sprintf($testStr, $arg);
 echo '<br/><hr/><br/>';
 
 /**
  *    9.    %x - 十六进制数（小写字母）
  *        同%d/%o一样。只不过参数传入一个小写字母的十六进制数值
  */
 $testStr    = "将十六进制数替换成十进制的 %o";
 $arg        = '456d12';
 echo sprintf($testStr, $arg);
 echo '<br/><hr/><br/>';
 
 /**
  *    10.    %X - 十六进制数（大写字母）
  *        同%d/%o/%x一样。只不过参数传入一个大写字母的十六进制数值
  *        貌似%x %X两个字母大小写没区别...
  */
 $testStr    = "将大写字母的十六进制数替换成十进制的 %o";
 $arg        = '456D12';
 echo sprintf($testStr, $arg);
 echo '<br/><hr/><br/>';
 
 /**
  *    11.    %s - 字符串
  *        用你传入的字符串替换掉%s
  */
 $string    = "这是用来测试的sprintf的字符串( %s )。今天消费了%f元。从西二旗到知春路有%d站。上班";
 $arg    = '';
 echo sprintf($string, $arg, 234, 10);
 echo '<br/><hr/><br/>';
 
  
  ?>