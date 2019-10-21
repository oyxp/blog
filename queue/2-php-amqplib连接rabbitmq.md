##1、使用composer安装php-amqplib
在你的项目中添加一个 composer.json文件：
```json
      {
         "require": {
          "php-amqplib/php-amqplib": "2.6.*"
         }
     }
```
只要你已经安装Composer功能，你可以运行以下：
  ```json
 $ composer install
 $ composer update
```
已经存在的项目则执行 
  ```json
 $ composer install
 $ composer update
```
这时在verdor目录就已经下载完毕

具体可以参考官方文档：https://github.com/php-amqplib/php-amqplib

##2、使用php-amqplib
英文文档：http://www.rabbitmq.com/getstarted.html
中文文档：https://rabbitmq.shujuwajue.com/tutorials_with_php/[2]Work_Queues.md.html

总结：官方文档看起来有点乱，总结了一下，基本都是互通的，以下为简单基本步骤，仅供参考，NO BB。



[========]

[========]



#生产者：
##1、创建连接

主要参数说明：

   >$host:  RabbitMQ服务器主机IP地址
   >$port:  RabbitMQ服务器端口
   $user:  连接RabbitMQ服务器的用户名
   $password:  连接RabbitMQ服务器的用户密码
   $vhost:   连接RabbitMQ服务器的vhost（服务器可以有多个vhost，虚拟主机，类似nginx的vhost）
    
```php
$connection =  new AMQPStreamConnection($host,$port,$user,$password,$vhost);
```

 
##2、获取信道  
>$channel_id 信道id，不传则获取$channel[“”]信道，再无则循环$this->channle数组，下标从1到最大信道数找第一个不是AMQPChannel对象的下标，实例化并返回AMQPChannel对象，无则抛出异常No free channel ids

```php
$channel = $connection->channel($channel_id);
```


##3、在信道里创建交换器

>  $exhcange_name 交换器名字
> $type 交换器类型：
 默认交换机 匿名交换器 未显示声明类型都是该类型
fanout  扇形交换器 会发送消息到它所知道的所有队列，每个消费者获取的消息都是一致的
headers 头部交换器
direct 直连交换器，该交换机将会对绑定键（binding key）和路由键（routing key）进行精确匹配
topic 话题交换器 该交换机会对路由键正则匹配，必须是*(一个单词)、#(多个单词，以.分割) 、      user.key .abc.* 类型的key
rpc 
$passive     false
$durable      false
$auto_detlete false 

```php
$channel->exchange_declare($exhcange_name,$type,$passive,$durable,$auto_delete);
//常用设置 $passive=>false  $durable=>false $auto_delete->false
```


##4、创建要发送的信息 ，可以创建多个消息
>$data  string类型 要发送的消息
>$properties array类型 设置的属性，比如设置该消息持久化[‘delivery_mode’=>2]

```php
$msg = new AMQPMessage($data,$properties)
```

##5、发送消息

>$msg object AMQPMessage对象
.$exchange string 交换机名字  
.$routing_key string 路由键 如果交换机类型

>fanout： 该值会被忽略，因为该类型的交换机会把所有它知道的队列发消息，无差别区别
direct  只有精确匹配该路由键的队列，才会发送消息到该队列
topic   只有正则匹配到的路由键的队列，才会发送到该队列

```php
$channel->basic_publish($msg,$exchange,$routing_key);
```

##6、关闭信道和链接
```php

$channel->close();
$connection->close();
```







[========]

[========]



#消费者：
##1、创建连接

主要参数说明：
>$host:  RabbitMQ服务器主机IP地址
$port:  RabbitMQ服务器端口
$user:  连接RabbitMQ服务器的用户名
$password:  连接RabbitMQ服务器的用户密码
$vhost:   连接RabbitMQ服务器的vhost（服务器可以有多个vhost，虚拟主机，类似nginx的vhost）

```php
$connection =  new AMQPStreamConnection($host,$port,$user,$password,$vhost);
```

 
##2、获取信道  
>$channel_id 信道id，不传则获取$channel[“”]信道，再无则循环$this->channle数组，下标从1到最大信道数找第一个不是AMQPChannel对象的下标，实例化并返回AMQPChannel对象，无则抛出异常No free channel ids

```php
$channel = $connection->channel($channel_id);
```



##3、在信道里创建交换器，未显式声明交换机都是使用匿名交换机

> $exhcange_name 交换器名字
> $type 交换器类型：

>默认交换机 匿名交换器 未显示声明类型都是该类型
fanout  扇形交换器 会发送消息到它所知道的所有队列，每个消费者获取的消息都是一致的
headers 头部交换器
direct 直连交换器，该交换机将会对绑定键（binding key）和路由键（routing key）进行精确匹配
topic 话题交换器 该交换机会对路由键正则匹配，必须是*(一个单词)、#(多个单词，以.分割) 、      user.key .abc.* 类型的key

>rpc 
$passive  false
durable false
auto_detlete false 

```php
$channel->exchange_declare($exhcange_name,$type,$passive,$durable,$auto_delete);
//常用设置 $passive=>false  $durable=>false $auto_delete->false
```




##4、声明消费者队列

>（1）    非持久化队列,RabbitMQ退出或者崩溃时，该队列就不存在

  ```php
list($queue_name, ,) = $channel->queue_declare("", false, false, false, false)
```
   
>（2）    持久化队列（需要显示声明，第三个参数要设置为true），保存到磁盘，但不一定完全保证不丢失信息，因为保存总是要有时间的。

```php
 list($queue_name, ,) = $channel->queue_declare("ex_queue", false, false, true, false)
```



##5、绑定交换机，当未显示绑定交换机时，默认是绑定匿名交换机

>绑定：交换机与队列的关系，如下面这句代码意思是，$queue_name队列对logs交换机数据感兴趣，该队列就消费该交换机传过来的数据：这个队列（queue）对这个交换机（exchange）的消息感兴趣. $binding_key默认为空，表示对该交换机所有消息感兴趣，如果值不为空，则该队列只对该类型的消息感兴趣（除了fanout交换机以外）
   $channel->queue_bind($queue_name, 'logs', $binding_key);


##6、消费消息

>该代码表示使用basic.qos方法，并设置prefetch_count=1。这样是告诉RabbitMQ，再同一时刻，不要发送超过1条消息给一个工作者（worker），直到它已经处理了上一条消息并且作出了响应。这样，RabbitMQ就会把消息分发给下一个空闲的工作者（worker），轮询、负载均衡配置

```php
 $channel->basic_qos(null, 1, null);
```


```php
第四个参数 no_ack = false 时，表示进行ack应答，确保消息已经处理
$callback 表示回调函数，传入消息参数
$channel->basic_consume('ex_queue', '', false, false, false, false, $callback);

$callback = function($msg){
  echo " [x] Received ", $msg->body, "\n";
  sleep(substr_count($msg->body, '.'));
  echo " [x] Done", "\n";

当no_ack=false时， 需要写下行代码，否则可能出现内存不足情况#$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

监听消息，一有消息，立马就处理
while(count($channel->callbacks)) {
    $channel->wait();
}
```



 