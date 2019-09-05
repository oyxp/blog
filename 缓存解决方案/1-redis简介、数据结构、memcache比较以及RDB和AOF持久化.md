 ### Redis基础
> redis是单进程单线程的NoSQL内存数据库，所有数据都存放在内存中，拥有超高的性能。
 ## 1、redis特点
 >Redis是一个key-value键值对的NoSQL数据库。支持多种数据类型，包括string（字符串）、List（链表）、Set（集合）、Zset（有序集合）和Hash（哈希）共5种。
     
        特点：
          1）、高速读取数据（数据放在内存）
          2）、减轻数据库负担
          3）、有集合计算功能
          4）、多种数据结构支持
          
       适合场景：
          1）、top n 【sorted set】
          2）、最新数据 【List】
          3）、计数器 【increby】
          4）、共同好友sns（social network site）【Set】
          
 
 
 ## 2、与memcache比较
 
       1）、数据类型：Redis支持5种数据结构类型，而memcache是只支持字符串类型。
       2）、单key存储大小：Redis单key支持最大1GB的数据，而memcache单key最大1M。
       3）、持久化：Redis支持RDB快照持久化和AOF持久化两种方式，将数据存储到磁盘，重启或断电绝大部分情况下能保证数据不丢失。而memcache是不支持持久化的，数据是存储在内存。
       4）、集群：Redis可以通过打开配置支持集群，而memcache需要自己实现集群。
 
 
 ## 3、数据类型
    
 **1）、string字符串类型**
 >基础数据类型，命令有set、get、del
 
 A：设置一个键值，返回`ok`
 `set key value`
 
 B：获取一个键值，无则返回`nil`
 `get key`
 
 c:删除一个键
 `del key`
 
 d：对key做加加操作，并返回新的值(必须是整型，(error) ERR value is not an integer or out of range)
  `incr key`
 
 e:对key做加加操作，加指定间距`dis`，并返回新的值
 `incrby key dis`
 
 ----------------------
 **2）、hash类型**
 >hash可以用来存储对应mysql中表的一条记录，类似关联数组。
 >例如User表
 
 id | username| gender
 ------------ | ------------- | ------------
  1 | snail  | 0
  2 | zed  | 1
 
 >（1）`hset`:  设置hash值
 
 用法：`hset key field value`
 在hash类型就可以这么存储：
 `user:id:1 username snail gender 0`
 `user:id:2 username zed gender 1`
 使用命令`hset`
 `hset user:id:1 username snail`
 也可以这么用
 `hset user:id:1 username snail gender 0`
 
 >（2）、`hget`：获取hash key的某一个field
 
 用法：`hget key field`
 `hget user:id:1 username`
 
 >（3）、`hmset`:同时设置hash的多个field
 
 用法：`hmset key field value field value ...`
 `hmset user:id:1 username snail gender 0`
 
 >（4）、`hmget`：同时获取hash多个field的值
 
 用法：`hmget key field1 field2...`，
 `hmget user:id:1 username gender`
 
 > （5）、`hgetall`：获取某个hash key的所有field值
 
 用法：`hgetall key`
 `hgetall user:id:1`
 
 ------------
 **3）、List类型**
 
 **4）、set类型**
 **5）、sorted set类型**
 
 
 
 ## 4、RDB快照持久化（snapshotting）
 >该持久化默认开启，默认一次性把redis中全部数据保存一份存储在磁盘中（默认名字为dump.rdb，如果数据非常多，就不适合频繁进行该持久化操作）
   
     （1）如何开启,默认开启，有触发条件
         save 秒  修改key的个数
         save 900 1：900s内，超过1个key被修改就持久化
         save 300 10:300s内，超过10个key被修改就持久化
      使用#可注释该配置
      
     （2）可设置保存位置和保存文件名
        dbfilename dump.rdb：设置文件名
        dir ./ ：设置文件存储路径
        
     （3）手动发起快照（这个是异步操作）
       
        1）、登录状态执行 bgsave
        2）、命令行执行./redis-cli bgsave
     
     （4）缺点：该快照方式会在一定间隔时间做快照，如果redis以外down机或断电，则会丢失最后一次快照后的所有修改
     
 ## 5、AOF持久化
 >本质：把用户执行的每个`写`的指令（添加、修改、删除）都备份到文件中，`还原数据就是将文件里面的指令执行一遍`
 
     （1）、开启，修改配置appendonly为yes
         appendonly yes
         
        设置文件名，可以指定路径
        appendfilename appendonly.aof
        
     （2）、触发条件
       appendfsync always:每次收到写命令，就立即强制写入磁盘，最慢，但是完整持久化，不推荐使用。
       appendfsync everysec:每秒钟强制写入磁盘一次，在性能和持久化方面做了很好的折中，推荐使用。
       appendfsync no:完全依赖os，性能最好，持久化没保证。
 
     （3）、aof文件的重写
       例如将多个incr指令换为一个set指令，可以减少aof文件大小。 语法： ./redis-cli -a 密码 bgrewriteaof或者登陆状态下执行 bgrewriteaof命令
       
     注意点：如果两种持久化方式都开启，则以aof为准。RDB方式恢复更快。
       
      
      
      
 ## 6、redis实现秒杀功能
 >使用redis的list类型，进行pop
 >   
      
     （1）将商品存入redis，存为一个redis队列
      
     （2）每获取一个，则pop一个，直到队列为空，则返回秒杀完毕
       
 
 
