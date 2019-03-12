# PHP常量

## 1、概念

     常量，不能改变的标量，一旦定义就不能被修改。

## 2、声明方式


声明常量有两种方式，`define()`函数和`const`关键字


## 3、`define()`和`const`声明常量区别

     （1）、define是函数声明，而const是语法结构；const是在PHP代码编译时定义变量
     而define则是在PHP运行时定义常量

     （2）、define定义常量时，可以使用表达式，表达式中可以包含变量，而const定义常量
     时，在PHP5.6版本以上才可以使用表达式，但表达式中不能包含变量


     （3）、define不能定义类、接口常量，而const则可以定义类以及接口常量

```php
<?php

//正常定义常量
const A = 1;//正确
define('A1', 2);//正确

//使用表达式定义
for ($i = 0; $i < 3; $i++)
{
	define('B' . $i, $i);//正确
	//const 'B'.$i = $i;//错误
}

class A
{
	const STATUS = 10; //正确
	//define('D',1); // 错误
}


echo A, PHP_EOL;//1
echo A1, PHP_EOL;//2
echo B0, PHP_EOL;//0
echo B1, PHP_EOL;//1
echo B2, PHP_EOL;//2
echo A::STATUS, PHP_EOL;//10
```

## 4、常见的一些常量

`__DIR__`:当前文件所在目录

`__FILE__`:当前文件完整路径

`__NAMESPACE__`:当前所在的命名空间

`__FUNCTION__`：当前所在的函数名

`__METHOD__`：当前所在的方法名，是包含了完整类名,如a\b\Person::a

`__CLASS__`：当前类名，是包含了完整类名,如a\b\Person

`__TRAIT__`：当前trait名，是包含了完整类名,如a\b\Person

`__LINE__`：当前行数

