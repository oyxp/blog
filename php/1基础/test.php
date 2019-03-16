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

//echo chr(97);//a
//echo PHP_EOL;
//echo ord('a');//97
//echo PHP_EOL;


//$string = 'abcdefghijklmnopqrxtuvabc';
//
//$str = str_replace(['a', 'b', 'c'], [1, 2, 3], $string);
//$str2 = str_replace('abcd', '123', $string);
//echo $str, PHP_EOL;//123defghijklmnopqrxtuv123
//echo $str2, PHP_EOL;//123efghijklmnopqrxtuvabc
//
//$search  = array('A', 'B', 'C', 'D', 'E');
//$replace = array('B', 'C', 'D', 'E', 'F');
//$subject = 'A';
//echo str_replace($search, $replace, $subject);//F

//printf("%u", ip2long('127.0.0.1'));//2130706433
//echo long2ip(2130706433);//127.0.0.1
//
//class Magic
//{
//	private $name;
//
//	/**构造方法 使用new关键字实例化对象时触发
//	 * Magic constructor.
//	 */
//	public function __construct()
//	{
//		var_dump(__METHOD__);
//	}
//
//	/**
//	 * 析构方法：越后声明的对象越先销毁，显式置为NULL会先销毁，和PHP GC回收机制，引用计数
//	 */
//	public function __destruct()
//	{
//		// TODO: Implement __destruct() method.
//		var_dump(__METHOD__);
//	}
//
//	/**
//	 *当使用 var_dump()打印对象时触发
//	 */
//	public function __debugInfo()
//	{
//		var_dump(__METHOD__);
//	}
//
//	/**
//	 *当使用 serialize()函数序列化对象时触发
//	 */
//	public function __sleep()
//	{
//		// TODO: Implement __sleep() method.
//		var_dump(__METHOD__);
//	}
//
//	/**
//	 *当使用 unserialize()函数反序列化对象时触发
//	 */
//	public function __wakeup()
//	{
//		// TODO: Implement __wakeup() method.
//		var_dump(__METHOD__);
//	}
//
//	/**
//	 *当把对象当成字符创输出时触发
//	 */
//	public function __toString()
//	{
//		var_dump(__METHOD__);
//		return '';
//	}
//
//	/**当调用不存在的方法时触发；不可访问的方法会报错
//	 *
//	 * @param $name
//	 * @param $arguments
//	 */
//	public function __call($name, $arguments)
//	{
//		// TODO: Implement __call() method.
//		var_dump(__METHOD__);
//	}
//
//	/**当调用不存在的静态方法时触发；不可访问的静态方法会报错
//	 *
//	 * @param $name
//	 * @param $arguments
//	 */
//	public static function __callStatic($name, $arguments)
//	{
//		// TODO: Implement __callStatic() method.
//		var_dump(__METHOD__);
//	}
//
//	/**
//	 * 使用 clone克隆对象时触发
//	 */
//	public function __clone()
//	{
//		// TODO: Implement __clone() method.
//		var_dump(__METHOD__);
//	}
//
//	/**
//	 *把对象当成函数来调用时触发
//	 */
//	public function __invoke()
//	{
//		// TODO: Implement __invoke() method.
//		var_dump(__METHOD__);
//	}
//
//	/**获取不可访问属性时触发(属性不存在，或者private、protected受限制不能访问)
//	 *
//	 * @param $name
//	 */
//	public function __get($name)
//	{
//		// TODO: Implement __get() method.
//		var_dump(__METHOD__);
//	}
//
//	/**设置不可访问属性时触发(属性不存在，或者private、protected受限制不能设置)
//	 *
//	 */
//	public function __set($name, $value)
//	{
//		// TODO: Implement __set() method.
//		var_dump(__METHOD__);
//	}
//
//	/**使用empty、isset访问不可访问属性时触发（（包括不存在和private、protected受访问限制的情况））
//	 *
//	 * @param $name
//	 */
//	public function __isset($name)
//	{
//		// TODO: Implement __isset() method.
//		var_dump(__METHOD__);
//	}
//
//	/**unset不可访问属性时触发（包括不存在和private、protected受访问限制的情况）
//	 *
//	 * @param $name
//	 */
//	public function __unset($name)
//	{
//		// TODO: Implement __unset() method.
//		var_dump(__METHOD__);
//	}
//}
//
//$m = new Magic(); //string(18) "Magic::__construct"
//echo $m;//string(17) "Magic::__toString"
//$m(1);//string(15) "Magic::__invoke"
//empty($m->name);//string(14) "Magic::__isset"
//isset($m->n);//string(14) "Magic::__isset"
//$m->name = 'SnailZED';//string(12) "Magic::__set"
//echo $m->name;//string(12) "Magic::__get"
//var_dump($m);//string(18) "Magic::__debugInfo"
//
//$ms = serialize($m);//string(14) "Magic::__sleep"
//$b = clone $m;//string(14) "Magic::__clone"
//
//unset($m->a);//string(14) "Magic::__unset"
//
////最后会调用两次__destruct，string(17) "Magic::__destruct"
////因为克隆出了一个对象

//class Factory
//{
//	/**传入类名
//	 *
//	 * @param string $class
//	 */
//	public static function make($class)
//	{
//		return new $class;
//	}
//}
//class Person
//{
//	public function eat()
//	{
//		echo 'EAT', PHP_EOL;
//	}
//}
//
//class Factory
//{
//	/**传入类名
//	 *
//	 * @param string $class
//	 */
//	public static function make($class)
//	{
//		return new $class;
//	}
//}
//
//Factory::make(Person::class)->eat();

class Sms
{
	/**
	 * @var \Sms
	 */
	private static $instance;

	/**私有化构造方法
	 * Sms constructor.
	 */
	private function __construct()
	{
	}

	/**
	 *私有化克隆方法
	 */
	private function __clone()
	{
		// TODO: Implement __clone() method.
	}

	/**获取本类实例对象
	 *
	 * @return \Sms
	 */
	public static function getInstance()
	{
		if (!(self::$instance instanceof self))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function sendSms()
	{
		echo 'Send sms', PHP_EOL;
	}
}

Sms::getInstance()->sendSms();

