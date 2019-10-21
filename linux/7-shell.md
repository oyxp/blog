### shell
>if [] 中括号内部左右两边必须加空格

#### 1、文件类型比较

    常用操作：
    -d filepath  判断该目录是否存在
    -f filename  判断是否为普通文件
    -e filename 判断文件是否存在
```shell
#!/bin/bash

FILE="/tmp/tmp.log"
DIR="/tmp/"

if [ -d "$DIR" ]
  then
   echo "It is a dir."
  else
   echo "It is not a dir"  
fi

if [ -f "$FILE" ]
  then
   echo "It is a dir."
  else
   echo "It is not a dir"  
fi

if [ -e "$FILE" ]
  then
   echo "It is a excutable file."
  else
   echo "It is not a excutable flie" 
fi
```

#### 2、文件权限比较


    常用操作：
    -r filename 判断文件是否可读 
    -w filename 判断文件是否可写
    -x filename 判断文件是否可执行
     
	 

------------

     注意，linux文件权限分为当前用户（u user）、当前用户组权限（g group）和其他用户权限（o other）
	  只要满足其中一组权限，返回结果都是true。
	  
	  
	 

#### 3、文件比较


     常用操作：
     filename1 –nt filename2  判断文件1是否比文件2更新（最后修改时间越大越新 new than）
     filename1 –ot filename2  判断文件1是否比文件2更旧（最后修改时间越小越旧 old than）
     filename1 –ef filename2  判断文件1是否等于文件2（inode号相同即为true）


#### 4、整数比较

     num1  -eq num2  判断num1是否等于num2
     num1  –nq num2  判断num1是否不等于num2
     num1 –gt num2   判断num1是否大于num2
     num1 –lt num2   判断num1是否小于num2
     num1 –ge num2   判断num1是否大于等于num2
     num1 –le num2   判断num1是否小于等于num2  



#### 5、字符串比较

     -z string   判断string是否为空
     -n string   判断string是否不为空
     string1 == string2  判断string1是否等于string2
     string1 != string2  判断string1是否不等于string2


#### 6、逻辑运算

     express1  -a  express2  => express1 && express2 与运算
     express1  -o  express2  => express1 or express2 或运算
     !express  非运算符

 


#### 7、IF语句

    1）、单分支语法
     if [ ];then
       …
     fi

     if [ ]
      then
       …
     fi
 
     2)、多分支
     if []
	   then
	    ...
	 	elif
		...
		else
		...
	fi	
	
	  case "$1" in 
	    a)
		    ...
		  ;;
		...
		*)
		...
		    ;;
eg:
  ```shell
#/bin/bash
user=$(whoami)
if [ “$user”==“snail”];then
 echo “Yes,I am snail”;
fi
```
####注意
     
	 坑1：if [] 中括号内部左右两边必须加空格
	 坑2：在做字符串或数字判断时，如果其中一个表达式为空，bash会报错，一般通用解决方法是拼接上一个字符
	 if [ "${a}z" == "az" ];then
	   echo ""
	 fi
