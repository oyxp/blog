# PHP流程控制

## 1、遍历数组的3种方式

（1）`for`循环遍历（`while`、`do while`）
>该种方式需要先求出整个数组的长度，且只能遍历索引数组
```php
<?php

$arr = range(0,100);
$count = count($arr);

for($i=0; $i<$count; $i++){
	echo $arr[$i];
}
```

（2）`foreach`循环遍历
>foreach遍历数组的效率最高，当数组越大越明显。遍历时会自动将指针移动到第一个元素，不需要调用reset()函数

```php
<?php

$arr = range(0,100);
$arr1 = [ 'a'=>'a'] ;

foreach($arr as $k => $value){
	echo $value;
}
```

（3）`list`、`each`和`while`组合遍历
>组合遍历数组时，需要先调用`reset(&$array)`函数，`重置指针`到数组的第一个元素

```php
<?php

$arr = range(0,100);
reset($arr);//重置数组指针
while(list($k,$value) = each($arr)){
	echo $value;
}

```

## 2、`if elseif`
   
    多条件判断，尽可能将可能性大的表达式提前，同时只有一个条件成立。当条件比较复杂时，则可以使用`switch case`优化。

## 3、`switch case`
    
    条件判断，PHP代码编译时会生成索引表，进行条件判断时，不会一条一条判断，会直接跳转到符合case子句。

## 4、如何优化 `if elseif ...`语句
   
     1）尽可能将可能性大的表达式提前
     2）如果条件判断比较复杂，则可以使用switch case语句改写