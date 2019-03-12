# PHP变量作用域和`static变量`

## 1、变量类型
> 变量分为`全局变量`和`局部变量`
   
     全局变量：定义于函数或者类外部的变量
     局部变量：定义于函数或方法内部的变量，两者的区别在于作用域不同
     
## 2、函数内部操作外部变量
> 函数内部是使用不了外部变量的，这点跟JavaScript不同。
   
     解决办法：
      （1）使用$GLOBALS超全局数组操作外部变量，直接操作的就是外部变量
      （2）使用global关键字引用外部变量，操作的是引用
      （3）使用其他超全局数组，如$_POST,$_GET
      （4）引用传递

```php
<?php

//方法1 使用$GLOBALS直接操作外部变量
$username = 'SnailZED';

function changUsername($username)
{
	$GLOBALS['username'] = $username;
//	unset($GLOBALS['username']);//unset之后，$username值为NULL
}

changUsername('Snail');
var_dump($username);//string(5) "Snail"


//方法2 使用global关键字引用外部变量
$username = 'SnailZED';
function changUsernameByGlobal($username1)
{
	global $username;
	$username = $username1;
	unset($username);//unset的是引用，不会影响外部值
}
changUsernameByGlobal('Snail');
var_dump($username);//string(5) "Snail"

//方法3 使用其他超全局数组
$_POST['username'] = 'SnailZED';

function changUsernameByGlobalArray($username1)
{
	$_POST['username'] = $username1;
}

changUsernameByGlobalArray('Snail');
var_dump($_POST['username']);

//方法4 引用传递
$username = 'SnailZED';
function changUsernameByReference(&$username1)
{
	$username1 = 'Snail';
}
changUsernameByReference($username);
var_dump($username);
```
## 3、static变量