# PHP数据类型
>PHP共有9种数据类型，分为4种标准类型（`整型`、`浮点型`、`布尔型`以及`字符串类型`）、2种复合类型（`Object对象类型`和`Array数组类型`）以及2种特殊类型（`Resource资源类型`和`NULL类型`）和 Callback/Callable回调类型

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


## 2、复合类型
> 复合类型包括 `Object`和`Array`两种类型

#### 1）、Object类型
      
      new创建的类实例或者clone出来的实例

```php
<?php

class Person {
	public $name;
	public function __construct($name) {
		$this->name = $name;
	}
}

$p = new Person('SnailZED');
```

#### 2）、Array类型
     
     PHP中的数组类型，实际上是一个有序映射，PHP数组可以存放不同类型的元素，而且数组长度是可以动态拓展的，这点跟强类型的语言是不同的。
     
     定义方式：
       $a = array('a',false , null);
       $b = [];    
  
```php
<?php

$a = array();
$b = [];

var_dump($a);
var_dump($b);
```  
  
## 3、特殊类型 
>特殊类型包含`Resource`资源类型和`NULL`类型  

#### 1）、Resource类型
     
     资源类型：保存了到外部资源的一个引用。资源是通过专门的函数来建立和使用的。例如文件句柄、redis连接或者mysql连接都属于资源类型。
     
```php
<?php

$redis = new Redis();
$redis->connect('127.0.0.1',6379);

var_dump($redis);
```

#### 2）、NULL类型

    特殊的 NULL 值表示一个变量没有值，唯一可能的值就是 NULL。
    值为NULL的情况有4种：
      （1）被赋值为NULL
      （2）定义但未被初始化的变量
      （3）未定义的变量
      （4）被unset的变量
      
```php
<?php

$a = NULL;
$b;//NULL

$d = 1;
unset($d);

var_dump($a);//NULL
var_dump($b);//NULL
var_dump($c);//NULL
var_dump($d);//NULL
```


## 4、回调类型 
> Callback/Callable回调类型

     一些函数如 call_user_func() 或 usort() 可以接受用户自定义的回调函数作为参数。回调函数不止可以是简单函数，还可以是对象的方法，包括静态类方法。
     一般使用call_user_func($callable,$arg1...)或者call_user_func_array($callable,[$arg1,$arg2...])来调用.
     两者区别：
       call_user_func调用时，参数从第二个开始是匿名函数参数列表
       call_user_func_array调用时，第二个参数则是数组，数组里面存放匿名函数调用参数列表。
       
       
      第一个参数都是匿名函数，可以是函数名字符串、数组形式
      数组形式：
        调用类的非静态方法：
          [类实例 , 类方法名]
          
        调用类的静态方法：
          [类名 , 类静态方法名]

  
 ```php
function f1()
{
	echo 'f1', PHP_EOL;
}

class A
{
	public function f2()
	{
		echo 'A->f2', PHP_EOL;
	}

	public static function f3()
	{
		echo static::class . '::f3' . PHP_EOL;
	}
}

class B extends A
{

}

call_user_func('f1');
call_user_func_array('f1', []);

$a = new A;
call_user_func([$a, 'f2']);
call_user_func_array([$a, 'f2'], []);


call_user_func([A::class, 'f3']);
call_user_func_array([A::class, 'f3'], []);

call_user_func([B::class, 'f3']);

//f1
//f1
//A->f2
//A->f2
//A::f3
//A::f3
//B::f3

 ```
