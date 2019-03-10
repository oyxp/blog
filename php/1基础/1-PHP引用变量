### PHP引用变量

#### 1、变量
> 计算机语言中能储存计算结果或能表示值抽象概念。变量可以通过变量名访问。
变量由两部分组成，`变量名`+`变量内存空间`

>声明：只能由`数字、字母以及下划线`组成，不能以`数字`开头


#### 2、引用变量概念
> 引用变量：允许使用不同的名称来操作同一变量内容


#### 3、引用变量定义
> 使用&来定义引用变量，注意&只能修饰变量


#### 4、引用变量使用场景
>1、使得方法或者函数可以有多个返回值（也可以返回一个数组）

例如`preg_match($pattern,$subject,&$matches = [])`函数,$matches就是一个引用变量，函数本身返回的是匹配的个数，当匹配出错时返回false
未匹配结果时返回0，否则返回匹配个数.

```
<?php

/**
*上传文件，失败的时候还需要返回错误信息
*上传成功返回true，失败返回false
*/
function upload($filename, $des, &$error = ''){
   $file = $_FILES[$filename] ?? '';
   if (empty($file)) {
      $error = 'empty file';
      return false;
   }
   if (!move_uploaded_file($file['tmp'], $des)) {
     $error = 'move uploaded file failed';
     return false;
   }
   return true;
}
```


>2、在方法或者函数内部操作外部变量
>在函数或方法内部操作外部变量一般有4种方法：`$GLOBALS超全局数组`、`global关键字引用变量`、`其他超全局数组`以及`引用传递`

```blade
<?php

$username = 'Snail';
function test(&$username){
    $username = 'ZED';
    echo $username,PHP_EOL;
}
echo $username,PHP_EOL;
test($username);
echo $username,PHP_EOL;

//输出
//Snail
//ZED
//ZED
```