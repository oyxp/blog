# PHP数据类型
>PHP共有8种数据类型，分为4种标准类型（`整型`、`浮点型`、`布尔型`以及`字符串类型`）、2种复合类型（`object对象类型`和`array数组类型`）以及2种特殊类型（`resource资源类型`和`NULL类型`）

## 1、标准类型
>`整型`、`浮点型`、`布尔型`以及`字符串类型`


#### 1）、整型（int integer）
 
      在PHP中，整型分为十进制整数、八进制整数（使用0开头）、十六进制整数（是有0x开头）或二进制（以0b开头）表示，前面可以加上可选的符号（- 或者 +）

```php
<?php
$a = 1234; // 十进制数
$a = -123; // 负数
$a = 0123; // 八进制数 (等于十进制 83)
$a = 0x1A; // 十六进制数 (等于十进制 26)
$a = 0b11111111; // 二进制数字 (等于十进制 255)
?>
```
#### 2）、浮点型（float）
     
     也叫浮点数 float，双精度数 double 或实数 real。浮点型不能用来做等值比较，会有精度问题。
     
```php
<?php
 $a = 1.234; //
 $b = 1.2e3; //e表示10，e3表示10的3次方，1200
 $c = 7E-10;//实数real，其实就是科学计数法
 
if (8 - 6.4 == 1.6)
{
	echo 'TRUE';
}
else
{
	echo 8 - 6.4, PHP_EOL;
	echo 'FALSE', PHP_EOL;
}

//output:
//1.6
//FALSE
 ?> 
``` 

#### 3）、布尔类型（Boolean）
  
    只有两个值，true(TRUE)和false(FALSE)。
    7种值为false的情况：
      0, 0.0, '0', '', [], false, NULL
      
    empty()：7种值为false返回true
    isset()：当变量未设置或者值为NULL，返回false，否则返回true
          
#### 4）、字符串类型（String）
    
     PHP中没有字符类型，只有字符串类型。定义字符串方式有3种，分别是双引号定义、单引号以及 heredoc、newdoc方式。
     
 ```php
<?php

$string1 = "I am a string!\n";//双引号定义

$string2 = 'I am a string!\n';//单引号定义

$heredoc = <<<EOF
I am a string!\n
I am a string!\n
heredoc方式定义的字符串 ${string1}\n;
EOF;

$newdoc = <<<'EOF'
I am a string!\n
I am a string!\n
newdoc方式定义的字符串 ${string1}\n;
EOF;



echo $string1;
echo $string2;
echo $heredoc;
echo $newdoc;

//I am a string!
//I am a string!\nI am a string!
//
//I am a string!
//
//heredoc方式定义的字符串 I am a string!
//
//;I am a string!\n
//I am a string!\n
 ```
     三种方式定义区别：
       1）、双引号和heredoc方式定义的字符串，里面的变量和特殊字符如"\n"会被解析；而单引号和newdoc方式定义的
       字符串里面的变量和特殊字符不会被解析；
       2）、heredoc和newdoc适合定义大文本字符串，而单引号和双引号则适合小文本字符串。