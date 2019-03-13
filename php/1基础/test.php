<?php
/**
 * Created by PhpStorm.
 * User: snail
 * Date: 2019/3/10
 * Time: 11:00 PM
 */
////正常定义常量
//const A = 1;//正确
//define('A1', 2);//正确
//
////使用表达式定义
//for ($i = 0; $i < 3; $i++)
//{
//	define('B' . $i, $i);//正确
//	//const 'B'.$i = $i;//错误
//}
//
////class A
////{
////	const STATUS = 10; //正确
////	//define('D',1); // 错误
////}
////
////
////echo A, PHP_EOL;//1
////echo A1, PHP_EOL;//2
////echo B0, PHP_EOL;//0
////echo B1, PHP_EOL;//1
////echo B2, PHP_EOL;//2
////echo A::STATUS, PHP_EOL;//10
//
//
//if (8 - 6.4 == 1.6)
//{
//	echo 'TRUE';
//}
//else
//{
//	echo 8 - 6.4, PHP_EOL;
//	echo 'FALSE', PHP_EOL;
//}
//
//$string1 = "I am a string!\n";//双引号定义
//
//$string2 = 'I am a string!\n';//单引号定义
//
//$heredoc = <<<EOF
//I am a string!\n
//I am a string!\n
//heredoc方式定义的字符串 ${string1}\n;
//EOF;
//
//$newdoc = <<<'EOF'
//I am a string!\n
//I am a string!\n
//newdoc方式定义的字符串 ${string1}\n;
//EOF;
//
//echo $string1;
//echo $string2;
//echo $heredoc;
//echo $newdoc;
//
//
////$a = NULL;
////$b;//NULL
////
////$d = 1;
////unset($d);
////
////var_dump($a);//NULL
////var_dump($b);//NULL
////var_dump($c);//NULL
////var_dump($d);//NULL
//
//
//function f1()
//{
//	echo 'f1', PHP_EOL;
//}
//
//class A
//{
//	public function f2()
//	{
//		echo 'A->f2', PHP_EOL;
//	}
//
//	public static function f3()
//	{
//		echo static::class . '::f3' . PHP_EOL;
//	}
//}
//
//class B extends A
//{
//
//}
//
//call_user_func('f1');
//call_user_func_array('f1', []);
//
//$a = new A;
//call_user_func([$a, 'f2']);
//call_user_func_array([$a, 'f2'], []);
//
//
//call_user_func([A::class, 'f3']);
//call_user_func_array([A::class, 'f3'], []);
//
//call_user_func([B::class, 'f3']);

//
//namespace a\b;
//
//class Person
//{
//	use P;
//
//	public function a()
//	{
//		echo __CLASS__;
//	}
//}
//
//trait P
//{
//	public function b()
//	{
//		echo __TRAIT__;
//		echo 2 ** 3;
//	}
//}
//
////(new Person())->b();
//$dir = '.';
//echo `ls ${dir}`;
////var_dump(shell_exec('ls -al'));
///
//interface Animal {
//	public function eat();
//}
//
//class Cat implements Animal{
//	public function eat(){
//		echo 'cat eat';
//	}
//}
//
//$a = new Cat;
//echo $a instanceof Animal ? 'YES':'NO';//YES
//echo $a instanceof Cat ? 'YES':'NO';//YES

//方法1
$username = 'SnailZED';
//
//function changUsername($username)
//{
//	$GLOBALS['username'] = $username;
////	unset($GLOBALS['username']);//unset之后，$username值为NULL
//}
//
//changUsername('Snail');
//var_dump($username);//string(5) "Snail"
//
//function changUsernameByGlobal($username1)
//{
//	global $username;
//	$username = $username1;
//	unset($username);//unset的是引用，不会影响外部值
//}
//
//changUsernameByGlobal('Snail');
//var_dump($username);//string(5) "Snail"
//
//
//$_POST['username'] = 'SnailZED';
//
//function changUsernameByGlobalArray($username1)
//{
//	$_POST['username'] = $username1;
//}
//
//changUsernameByGlobalArray('Snail');
//var_dump($_POST['username']);
//
//$username = 'SnailZED';
//function changUsernameByReference(&$username1)
//{
//	$username1 = 'Snail';
//}
//
//changUsernameByReference($username);
//var_dump($username);

//$cities = [
//	[
//		'id'   => 1,
//		'pid'  => 0,
//		'name' => '广东省'
//	],
//	[
//		'id'   => 2,
//		'pid'  => 0,
//		'name' => '山东省'
//	],
//	[
//		'id'   => 3,
//		'pid'  => 0,
//		'name' => '北京市'
//	],
//	[
//		'id'   => 4,
//		'pid'  => 1,
//		'name' => '深圳市'
//	],
//	[
//		'id'   => 5,
//		'pid'  => 2,
//		'name' => '烟台市'
//	],
//	[
//		'id'   => 6,
//		'pid'  => 1,
//		'name' => '广州市'
//	],
//];
//function testStatic(array $cities, $pid = 0, $level = 0)
//{
//	static $results = [];
//	foreach ($cities as $city)
//	{
//		if ($city['pid'] === $pid)
//		{
//			$city['level'] = $level;
//			$results[] = $city;
//			testStatic($cities, $city['id'], $level + 1);
//		}
//	}
//	return $results;
//}
//
//var_dump(testStatic($cities));

//$subject = '11abcdrtr';
////$substr = '1ab';
////
////if (strpos($subject, $substr))
////{
////	echo 'contains';
////}
////else
////{
////	echo 'not contains';
////}
///
///
//$email = 'name@example.com';
//$domain = strstr($email, '@');// @ea 结果也是一样
//echo $domain; // 打印 @example.com
//
//echo PHP_EOL;
//$user = strstr($email, '@', true); // 从 PHP 5.3.0 起
//echo $user; // 打印 name
//echo PHP_EOL;

//$user_ids = [1, 22, 33, 44, 55];
//$user_id_string = '('. implode(',', $user_ids).')';
//echo $user_id_string;//(1,22,33,44,55)

//$string = '1-2-3';
//
//var_dump(explode('-', $string));
//var_dump(explode('-', $string, 0));
//var_dump(explode('-', $string, 1));
//var_dump(explode('-', $string, 2));
//var_dump(explode('-', $string, -1));
//var_dump(explode('-', $string, -2));
//var_dump(explode('-', $string, -3));
//var_dump(explode('-', $string, -4));
//

//$string = '123456';
//echo strrev($string);

$money = 123456.789123;

echo number_format($money, 2, '.', '');//123456.79
echo PHP_EOL;
echo number_format($money, 3, '.', ',');//123456.78
echo PHP_EOL;

die;