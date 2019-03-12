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
> static变量
   
       特点：
        （1）只能修饰局部变量，只能定义在函数或方法内部
        （2）static变量只会初始化一次
        （3）static变量在函数或方法结束后，不会释放
         
 ```php
 <?php

//无线分级代码实现
$cities = [
	[
		'id'   => 1,
		'pid'  => 0,
		'name' => '广东省'
	],
	[
		'id'   => 2,
		'pid'  => 0,
		'name' => '山东省'
	],
	[
		'id'   => 3,
		'pid'  => 0,
		'name' => '北京市'
	],
	[
		'id'   => 4,
		'pid'  => 1,
		'name' => '深圳市'
	],
	[
		'id'   => 5,
		'pid'  => 2,
		'name' => '烟台市'
	],
	[
		'id'   => 6,
		'pid'  => 1,
		'name' => '广州市'
	],
];
function testStatic(array $cities, $pid = 0, $level = 0)
{
	static $results = [];//只会被初始化一次，函数执行完毕后不会释放，只能修饰局部变量
	foreach ($cities as $city)
	{
		if ($city['pid'] === $pid)
		{
			$city['level'] = $level;
			$results[] = $city;
			testStatic($cities, $city['id'], $level + 1);
		}
	}
	return $results;
}

var_dump(testStatic($cities));

/**
* array(6) {
    [0]=>
    array(4) {
      ["id"]=>
      int(1)
      ["pid"]=>
      int(0)
      ["name"]=>
      string(9) "广东省"
      ["level"]=>
      int(0)
    }
    [1]=>
    array(4) {
      ["id"]=>
      int(4)
      ["pid"]=>
      int(1)
      ["name"]=>
      string(9) "深圳市"
      ["level"]=>
      int(1)
    }
    [2]=>
    array(4) {
      ["id"]=>
      int(6)
      ["pid"]=>
      int(1)
      ["name"]=>
      string(9) "广州市"
      ["level"]=>
      int(1)
    }
    [3]=>
    array(4) {
      ["id"]=>
      int(2)
      ["pid"]=>
      int(0)
      ["name"]=>
      string(9) "山东省"
      ["level"]=>
      int(0)
    }
    [4]=>
    array(4) {
      ["id"]=>
      int(5)
      ["pid"]=>
      int(2)
      ["name"]=>
      string(9) "烟台市"
      ["level"]=>
      int(1)
    }
    [5]=>
    array(4) {
      ["id"]=>
      int(3)
      ["pid"]=>
      int(0)
      ["name"]=>
      string(9) "北京市"
      ["level"]=>
      int(0)
    }
  }
 */
 ```