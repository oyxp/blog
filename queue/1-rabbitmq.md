# RabbitMQ

## 1、简介

## 2、消费模型：
    
     producer----》exchange交换机----》队列
     
     producer：消息发布者，只需要将消息发送到交换机即可，不清楚消息是如何发送到队列的；
     exchange：负责接收消息和发送消息到队列
     queue：消费者从队列中取出消息进行通信
     
## 3、交换机类型：
        header头部交换机：很少用到
        redirect直连交换机：通过路由键的精确匹配将消息发送到相应的队列
        fanout扇形交换机：将消息发送给所有跟该交换机绑定的队列，类似广播
        topic主题交换机：类似发布订阅，也是通过路由键来讲消息发送到队列，非精确匹配，路由键必须是由.分割的词语，可以使用*，#来实现模糊匹配
        
     
     同一个队列，由多个消费者同时进行消费，那么其实是工作队列模式，默认是将消息以轮询方式发送到消费者。
        
        
## 4、消息消费模式
        