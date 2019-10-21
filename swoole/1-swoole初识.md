# swoole

## 1、什么是swoole



## 2、swoole启动流程：
     首先启动master进程，然后再fork出manager进程，manager进程再fork出work和task进程；
     
     master进程：多线程进程，包含reactor线程组，master线程、心跳检测线程以及udp收包线程；master线程负责监听端口，接收tcp连接，并将连接分配给reactor线程，由reactor线程来处理和监听连接，并将请求转发到work进程进行处理；
     
     manager进程：负责管理worker和task进程
     
     worker进程：处理reactor线程发送过来的请求，生成数据将返回到reactor线程，由reactor线程通过tcp连接返回到客户端（UDP则不需要将处理结果返回给reactor线程，worker进程直接发送到客户端）
     
     task进程：同步阻塞方式运行，一个task进程正在处理任务时，是不会接受从worker进程投递过来的任务，必须等task进程处理完成；task进程处理任务完成之后，会异步通知worker进程。