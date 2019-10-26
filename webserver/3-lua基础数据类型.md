# Lua基础数据类型
> lua中一共6种基本数据类型，分别是nil,boolean,string,table,function,number。可以使用`type`函数来判断一个值的数据类型

```lua
print(type(print)) -- function
print(type(360.1)) -- number
print(type("HI")) -- string
print(type(true)) -- boolean
print(type(nil)) -- nil
```

## 1、`nil`类型

> nil 空类型
1. 一个变量未赋值时，其值为nil；
2. 将nil赋值给全局变量等同于删除该变量
3. nil表示空，openresty的lua接口提供的`ngx.nil`，用来表示不同于nil的空值

```lua
local num
print(num) -- nil，未初始化的值默认为nil

num = 100
print(num) -- 100

local str
print(str)
str = 'Hi oy'
print(str)

```

## 2、布尔类型 `boolean`
> 可选值`true/false`，在lua中`只有false和nil为false，其他都为true`


```lua
-- 布尔类型,boolean
-- 可选值为true/false，在lua中只有 false和nil 为假，其他都为真


local b1
print(b1) -- nil

b1 = true
print(b1) -- true

-- 定义一个函数判断值的真假
function checkBool(b1)
    if b1 then
        print("值为真")
    else
        print("值为假")
    end
end

checkBool(true) -- true
checkBool("Hi") -- true
checkBool(1)-- true
checkBool(0) -- true
checkBool("")-- true
checkBool("0")  --true
checkBool(print)  --true
checkBool(checkBool) -- true

checkBool(false) -- false
checkBool(nil)  -- false
```

## 3、`number`数字类型
>数字类型表示实数类型。lua中提供`math`库操作实数。Lua中使用双精度浮点数实现。而luajit则会根据上下文
判断：如果是整数则用整数存储，小数则用双精度浮点数实现。

```lua

-- number数字类型
-- lua使用number类型来表示实数类型（整数和浮点数），一般使用双精度浮点数来表示。luajit中则会根据上下文判断，
-- 整数：采用整数类型来存放，支持长整型，浮点数：双精度浮点数存放
-- lua有提供math库来操作数字类型

local n1 = 1
local n2 = 1.1314

print(n1) -- 1
print(n2) -- 1.1314
print(math.ceil(n1)) -- 1
print(math.ceil(n2)) -- 1.1314
print(9223372036854775807LL -1 ) --  9223372036854775806LL
```

## 4、string字符串类型
> lua有提供string操作库。字符串类型在lua中有3种表示方式：

1. 使用双引号`""`
      
       local s1 = "HI"
      
2. 使用单引号`''`

       local s2 = 'H1' 
      
3. 长括号`[[]]`

       local s3 = [[ "Hi", 'me']]


> lua字符串特点：
   
     1、lua中字符串是不可修改的（要修改只能创建新的字符串），也不能通过下标方式读取某个字符
     2、相同字符串在lua虚拟机中只有一份，不会占用多份空间，也不会有新的内存分配
     3、已经创建好的lua字符串之间进行的相等性比较是O(1)时间复杂度
 

```lua


-- string字符串类型
-- lua中只有字符串类型，没有字符类型，这点跟PHP一样。
-- lua中有3种表示字符串的方式，分别是 双引号、单引号和 [[]]
-- 单引号和双引号定义的字符串没区别，里面的特殊字符不会被转义
-- [[]]方式定义的字符串，则会原样输出


local s1 = "Hello\nWorld"
local s2 = 'Hello World\n'
local s3 = [["H\n"]]

print(s1)  -- hello换行符World
print(s2)  -- Hello World加换行符
print(s3)  -- "H\n",带了双引号，原样输出

-- Lua字符串的特点：
-- 1、字符串不能被修改，也不能通过下标来访问某个字符。如要修改字符串，需要新创建一个字符串
-- 2、相同字符串在lua虚拟机中只有一份，使用链表来存储。创建相同的字符串不会有新的内存分配。
-- 3、相同字符串进行相等性比较直邮，时间复杂度直邮O(1)
```


##  5、`table`表类型
> table类型可以抽象的认为是关联数组(类似php的关联数组)，其下标类型可以是数字和字符串类型，也可以是除了nil的其他任意类型，
在lua中是非常重要的一个数据类型。下标如果是数字类型，则从1开始计数。

使用注意事项
1. 字符串下标的值可以使用`.`或者`[]`来使用
2. 数字下标的值则必须使用 `[]`来使用

```lua

-- table类型：关联数组
-- 下标类型通常是数字或字符串类型，数字类型是从下标1开始计算如果没明确指明下标，下标也可以是除了nil以外的所有类型
-- table类型使用{}定义，里面是key=value键值对

local t1 = {
    web = "baidu.com",
    web = "baidu.com1",
    ["web"] = "121", -- 会覆盖上面相同键的值
    "index1", -- 下标为1
    "index2", -- 下标为2
    [4] = "index3", -- 指定下标为4

    hobbies = {
        "basketball", 'football', 'pingpong'
    }
}

print(t1) -- 打印出地址
print(t1.web) -- 会覆盖上面相同键的值，以最后的为准，121
print(t1[0]) -- 下标是从1开始，nil
print(t1[1]) -- index1
print(t1[2]) --  index2
print(t1[3]) --  nil
print(t1[4]) --  index3
print(t1.hobbies[1]) -- basketball
print(t1["hobbies"][1]) -- basketball

-- 使用注意事项：
-- 1、字符串下标可以使用.或者[""]使用
-- 2、数字下标则必须使用[下标]使用
```

## 6、`function`函数类型
> 函数也是一种数据类型（和js有点像。。）,函数可以存储在变量中，也可以作为参数传递给其他函数，也可以作为其他函数的返回值。

1. 存储在变量中，其实就是匿名函数
2. 作为参数传递给其他函数
3. 作为其他函数的返回值


```lua

-- function函数类型，和js的函数一样，都是一种数据类型
-- 1、函数可以存储在变量中，可以通过变量来调用函数，匿名函数
-- 2、函数可以作为参数传递给其他函数
-- 3、可以作为其他函数的返回值


--普通定义
function fn(func, n1, n2)
    print(func(n1, n2))
end

-- 存放在变量中
local add_fn = function(n1, n2)
    return n1 + n2
end

local sub_fn = function(n1, n2)
    return n1 - n2
end

-- 作为参数传入给其他函数
fn(add_fn, 1, 2) -- 3
fn(sub_fn, 3, 2)  --1 

-- 作为其他函数的返回值
function returnFn()
    return function(a, b)
        return a * b
    end
end

f = returnFn()
print(f(3, 2)) --6
```
