# PHP运行原理

>1、版本控制软件（集中、分布式）

    CVS，SVN：
    GIT：
    
>2、PHP运行原理 nginx+PHP-FPM

    webserver接受到客户端请求之后，会将请求交给CGI进程（语言解析器）处理，CGI进程处理完请求之后按照CGI协议格式返回给websever，webserver再将结果返回给客户端。

     CGI：common gateway inteface，实现web服务器与后台语言通信（语言解析器），webserver每次处理一个请求都会fork一个CIG进程来处理，处理完毕后再kill掉该进程，浪费资源运行效率低
     fast-cgi：cgi的改进版本，fast-cgi处理请求不会kill掉，处理完一定数量的请求再kill，启动新的进程
     PHP-FPM：(fast-cgi process manager)fast-cgi进程管理器，也实现了fast-cgi协议
        master进程：1个，监听端口，管理worker进程，默认9000端口
        worker进程：多个，处理PHP代码

> 3、常见配置项
 

    register_globals:注入变量
    allow_url_fopen:允许打开远程文件
    allow_url_include:允许包含远程恩建
    date.timezone:默认时区
    display_errors:显示错误
    error_reporting:显示错误级别设置
    safe_mode:是否启用 PHP 的安全模式
    upload_max_filesize:上传的最大文件大小，默认2M
    max_file_uploads:最多同时允许多少文件上传，默认20
    post_max_size:最大post请求大小
    