# 会话控制
## 1、cookie和session区别及其工作原理
  
    session作用：存储在服务器端，保存用户状态，允许服务器跟踪同一个客户端做出的连续请求
     实现：使用GET参数传递
     操作：
       $_SESSION
       
     配置：
       session.auto_start:是否在请求开始时自动启动一个会话，默认为0（不启动）
       session.cookie_domain:指定了要设定会话 cookie 的域名
       session.cookie_lifetime:以秒数指定了发送到浏览器的 cookie 的生命周期，默认为 0，表示“直到关闭浏览器”。
       session.cookie_path:指定了要设定会话 cookie 的路径。默认为 /
       session.name:指定会话名以用做 cookie 的名字，默认为 PHPSESSID
       session.save_path:定义了传递给存储处理器的参数。如果选择了默认的 files 文件处理器，则此值是创建文件的路径。默认为 /tmp
       session.use_cookies:指定是否在客户端仅仅使用 cookie 来存放会话 ID。
       session.use_trans_sid:session.use_trans_sid 指定是否启用透明 SID 支持。默认为 0（禁用）,不安全。
      
      优缺点：安全
        1、session占用服务器端资源，session文件可能会越来越多。
        2、session共享，多态服务器session共享（mysql、redis）即公共空间即可
        
       
       //gc，垃圾回收, gc_probability/gc_divisor，这样的几率来判断session是否过期，就是1%概率启动GC进行垃圾回收。
       session.gc_probability:默认1
       session.gc_divisor:默认100
       session.gc_maxlifetime:默认1440s
       
       //
       session.save_handler:
    
    
    cookie：存储在客户端，服务器发送给客户端的用户信息
    操作：
    setcookie($name,$value,$expire,$path,$domain,$secure)
    通过设置expire来删除cookie
    获取：$_COOKIE
    优缺点:
    
    
    区别：
      1、存储：session是存储在服务器端，cookie是存放在客户端
      2、安全性：session因为是存放在服务器，cookie是存放在客户端，对用户可见，所以会session比cookie 更安全
      
      
## 2、cookie禁用，如何使用session
   
   将session_id通过GET方式传输。不安全，容易被攻击。
   session_name():sessionid的名字
   session_id():sessionid值
   
```
<a href='1.php?<?php echo session_name().'='.session_id();?>'></a>

//SID就是session_name()和session_id()值的拼接，如果禁用了cookie，SID就是拼接值，如果开启了，SID为空
<a href='1.php?<?php echo SID;?>'></a>
```

```
//当cookie禁用后，后端代码
<?php
$session_id = $_GET[session_name()] ?? '';
//不为空就设置当前会话的sessionid
if(!empty($session_id)){
   session_id($session_id);
}

session_start();
//执行逻辑后，最终要把sessionid返回给前端
```
