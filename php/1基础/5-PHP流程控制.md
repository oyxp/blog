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


## 3、`switch case`


## 4、如何优化 `if elseif ...`语句