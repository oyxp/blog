# php常见的一些坑以及如何解决

## 1、foreach引用的坑
```php

$a = array('a','b','c');
foreach($a as &$v){}
 
foreach($a as $v){
	var_dump($a);
}


array(3) {
  [0]=>
  string(1) "a"
  [1]=>
  string(1) "b"
  [2]=>
  &string(1) "a"
}
array(3) {
  [0]=>
  string(1) "a"
  [1]=>
  string(1) "b"
  [2]=>
  &string(1) "b"
}
array(3) {
  [0]=>
  string(1) "a"
  [1]=>
  string(1) "b"
  [2]=>
  &string(1) "b" 
}


//原理解析：foreach遍历时，会先初始化$v变量
foreach($a as &$v){}: 每次遍历时， $a[$i]和 $v指向同一个变量地址，修改$v的值，其实是直接修改$a[$i]的值，遍历到最后$v和$a[$i]指向同一个变量内存,此时$v在遍历结束后是不会被销毁的，也可以被外部访问。

下一次遍历开始时，还是使用$v
第一次遍历: 将a赋值给$v，也就是将a赋值给了最后一个元素，所以是 a,b,a;
第二次循环:$v还是指向最后一个元素，此时把b赋值给最后一个元素，即a,b,b；
最后一次循环:把b赋值给b,所以最后还是 a,b,b
```
