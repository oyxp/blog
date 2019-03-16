# 面向对象编程 OOP

>面向对象的3大特性：封装、继承、多态。单一继承性

## 1、三大特性

     （1）封装性
        public：类的内部和外部使用
        protected：类的内部、子类的内部使用
        private：类的内部
        
     （2）继承性
        extend：
        trait：新特性，解决PHP单继承
        
     （3）多态：同一类型对象却有不同的行为
     
     
## 2、魔术方法
    
       __construct():构造函数，使用new关键字创建对象；也可以使用同类名的方法名，也是构造函数
       __destruct():析构函数，越后使用的对象越先销毁，显示置为NULL，会越先销毁；跟PHP垃圾回收机制一致，引用计数。
       __clone():clone(obj)克隆对象
       __debugInfo():var_dump打印对象触发
       __sleep():使用serialize()序列化对象
       __wakeup():使用unserialize()反序列对象触发，如果需要使用反序列化的对象，需要引入该对象所属类的定义
       __call($method,$arguments):调用不存在方法时触发
       __callStatic($method,$arguments):调用不存在的static方法触发
       __get($name):获取不可访问属性触发
       __set($name,$value):设置不可访问属性时触发
       __toString():把对象当成字符串输出
       __isset():对不可访问属性使用empty()或者isset()
       __unset():对不可访问属性使用unset()
       __invoke():把对象当成函数调用时触发
       
  ```php
class Magic
{
	private $name;

	/**构造方法 使用new关键字实例化对象时触发
	 * Magic constructor.
	 */
	public function __construct()
	{
		var_dump(__METHOD__);
	}

	/**
	 * 析构方法：越后声明的对象越先销毁，显式置为NULL会先销毁，和PHP GC回收机制，引用计数
	 */
	public function __destruct()
	{
		// TODO: Implement __destruct() method.
		var_dump(__METHOD__);
	}

	/**
	 *当使用 var_dump()打印对象时触发
	 */
	public function __debugInfo()
	{
		var_dump(__METHOD__);
	}

	/**
	 *当使用 serialize()函数序列化对象时触发
	 */
	public function __sleep()
	{
		// TODO: Implement __sleep() method.
		var_dump(__METHOD__);
	}

	/**
	 *当使用 unserialize()函数反序列化对象时触发
	 */
	public function __wakeup()
	{
		// TODO: Implement __wakeup() method.
		var_dump(__METHOD__);
	}

	/**
	 *当把对象当成字符创输出时触发
	 */
	public function __toString()
	{
		var_dump(__METHOD__);
		return '';
	}

	/**当调用不存在的方法时触发；不可访问的方法会报错
	 *
	 * @param $name
	 * @param $arguments
	 */
	public function __call($name, $arguments)
	{
		// TODO: Implement __call() method.
		var_dump(__METHOD__);
	}

	/**当调用不存在的静态方法时触发；不可访问的静态方法会报错
	 *
	 * @param $name
	 * @param $arguments
	 */
	public static function __callStatic($name, $arguments)
	{
		// TODO: Implement __callStatic() method.
		var_dump(__METHOD__);
	}

	/**
	 * 使用 clone克隆对象时触发
	 */
	public function __clone()
	{
		// TODO: Implement __clone() method.
		var_dump(__METHOD__);
	}

	/**
	 *把对象当成函数来调用时触发
	 */
	public function __invoke()
	{
		// TODO: Implement __invoke() method.
		var_dump(__METHOD__);
	}

	/**获取不可访问属性时触发(属性不存在，或者private、protected受限制不能访问)
	 *
	 * @param $name
	 */
	public function __get($name)
	{
		// TODO: Implement __get() method.
		var_dump(__METHOD__);
	}

	/**设置不可访问属性时触发(属性不存在，或者private、protected受限制不能设置)
	 *
	 */
	public function __set($name, $value)
	{
		// TODO: Implement __set() method.
		var_dump(__METHOD__);
	}

	/**使用empty、isset访问不可访问属性时触发（（包括不存在和private、protected受访问限制的情况））
	 *
	 * @param $name
	 */
	public function __isset($name)
	{
		// TODO: Implement __isset() method.
		var_dump(__METHOD__);
	}

	/**unset不可访问属性时触发（包括不存在和private、protected受访问限制的情况）
	 *
	 * @param $name
	 */
	public function __unset($name)
	{
		// TODO: Implement __unset() method.
		var_dump(__METHOD__);
	}
}

$m = new Magic(); //string(18) "Magic::__construct"
echo $m;//string(17) "Magic::__toString"
$m(1);//string(15) "Magic::__invoke"
empty($m->name);//string(14) "Magic::__isset"
isset($m->n);//string(14) "Magic::__isset"
$m->name = 'SnailZED';//string(12) "Magic::__set"
echo $m->name;//string(12) "Magic::__get"
var_dump($m);//string(18) "Magic::__debugInfo"

$ms = serialize($m);//string(14) "Magic::__sleep"
$b = clone $m;//string(14) "Magic::__clone"

unset($m->a);//string(14) "Magic::__unset"

//最后会调用两次__destruct，string(17) "Magic::__destruct"
//因为克隆出了一个对象
  ```

## 3、设计模式
> 设计模式使用时，会比较纠结使用`interface`接口还是`abstract class`抽象类来定义接口实现，个人观点是：`如果实现的功能需要调用相同的方法，那么使用抽象类，否则使用接口；因为抽象类允许实现方法，而接口不行`   
       
       工厂模式：使用统一的方法来构造所有对象，方便管理对象
       单例模式：在创建对象之前会先判断对象是否已经存在，如何已存在则返回
       注册树模式：工厂单例模式,
       适配器模式：为了实现同一种功能，定义一个统一接口，然后由不同的方式来实现该接口。
       观察者模式：当事件发生时，将该事件通知该事件感兴趣的观察者。
       策略模式：根据不同的条件，使用不同的策略。
