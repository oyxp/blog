### MySQL innodb select加锁分析

#### 1、锁类型
   
>锁共分4种：

     读锁（共享锁，S锁）：事务T1对数据A加了读锁，那么事务T2只能对数据A进行读操作，而不能进行修改 
     
     写锁（排它锁，X锁）：事务T1对数据A加了写锁，那么事务T2不能对数据A进行读操作，也不能进行修改 
     
     意向共享锁（IS锁）：一个事务在获取（任何一行/或者全表）S锁之前，一定会先在所在的表上加IS锁。
     
     意向排它锁（IX锁）：一个事务在获取（任何一行/或者全表）X锁之前，一定会先在所在的表上加IX锁。
     
     意向锁意义：解决锁冲突。假设事务T1，用X锁来锁住了表上的几条记录，那么此时表上存在IX锁，即意向排他锁。那么此时事务T2要进行LOCK TABLE … WRITE的表级别锁的请求，可以直接根据意向锁是否存在而判断是否有锁冲突

**我们通过update、delete等语句加上的锁都是行级别的锁。只有LOCK TABLE … READ和LOCK TABLE … WRITE才能申请表级别的锁。**


#### 2、加锁算法
> 1）、行锁（record locks）
  
    该锁是对索引记录进行加锁！锁是在加索引上而不是行上的。注意了，innodb一定存在聚簇索引，因此行锁最终都会落到聚簇索引上！
  
> 2）、间隙锁（Gap Locks）
   
    简单翻译为间隙锁，是对索引的间隙加锁，其目的只有一个，防止其他事物插入数据。在Read Committed隔离级别下，不会使用间隙锁。这里我对官网补充一下，隔离级别比Read Committed低的情况下，也不会使用间隙锁，如隔离级别为Read Uncommited时，也不存在间隙锁。当隔离级别为Repeatable Read和Serializable时，就会存在间隙锁。

> 3)、行锁+间隙锁 （Next-Key Locks）

    锁住的是索引前面的间隙！比如一个索引包含值，10，11，13和20。那么，间隙锁的范围如下

```
(negative infinity, 10]
(10, 11]
(11, 13]
(13, 20]
(20, positive infinity)
```

#### 3、事务隔离级别
> 1）、未提交读（read uncommitted，RU）
    
    事务A会读取到事务B未提交的数据。事务未提交就能读取到数据。即脏读。
> 2）、提交读（read committed，RC）
   
    事务提交之后才能读取到。大部分数据库事务默认隔离级别就是提交读，mysql除外，其默认级别是可重复读。前一次读取和后一次读取的数据可能不一样，即不可重复读。一个事务从开始到提交前，对其他事务都是不可见的。
    
> 3）、可重复读（repeatable read，RR ）

    Mysql默认的事务隔离级别。避免了脏读问题，但可能带来幻读问题。当事务读取某些范围的记录时，有可能再次读取时，这些范围的数据已经发生了改变，即幻读。但在innodb和xtraDb存储引擎通过并发版本控制解决了幻读的问题。
   
> 4）、可串行化（Serializable）
   
    最高隔离级别。强制事务串行执行，避免了脏读和幻读，但性能低。会在读取的每一行数据都加锁，即使用了共享锁，所以可能导致大量的超时和锁竞争问题。


#### 4、不同隔离级别的加锁分析
假设有表如下（pId为聚簇索引,一般聚簇索引都是主键ID上建立的）

pid | num | name
:----------- | :-----------: | -----------:
1         | aaa        | 100
2         | bbb        | 200
3         | bbb        | 300
7         | ccc        | 200

当前读：加锁的读取
快照读：不加锁的读取，可串行化级别不成立

>1) RC/RU+条件列非索引
```
(1)select * from table where num = 200
不加任何锁，是快照读。
(2)select * from table where num > 200
同(1)
(3)select * from table where num = 200 lock in share mode
当num = 200，有两条记录。这两条记录对应的pId=2，7，因此在pId=2，7的聚簇索引上加行级S锁，采用当前读。
(4)select * from table where num > 200 lock in share mode
当num > 200，有一条记录。这条记录对应的pId=3，因此在pId=3的聚簇索引上加上行级S锁，采用当前读。
(5)select * from table where num = 200 for update
当num = 200，有两条记录。这两条记录对应的pId=2，7，因此在pId=2，7的聚簇索引上加行级X锁，采用当前读。
(6)select * from table where num > 200 for update
当num > 200，有一条记录。这条记录对应的pId=3，因此在pId=3的聚簇索引上加上行级X锁，采用当前读。
```
> 2) RC/RU+条件列是聚簇索引

```
恩，大家应该知道pId是主键列，因此pId用的就是聚簇索引。此情况最终结果其实和RC/RU+条件列非索引情况是类似的，但是过程不一样！

(1)select * from table where pId = 2
不加任何锁，是快照读。
(2)select * from table where pId > 2
同(1)
(3)select * from table where pId = 2 lock in share mode
在pId=2的聚簇索引上，加S锁，为当前读。
(4)select * from table where pId > 2 lock in share mode
在pId=3，7的聚簇索引上，加S锁，为当前读。
(5)select * from table where pId = 2 for update
在pId=2的聚簇索引上，加X锁，为当前读。
(6)select * from table where pId > 2 for update
在pId=3，7的聚簇索引上，加X锁，为当前读。

这里，大家可能有疑问

为什么条件列加不加索引，加锁情况是一样的？
ok,其实是不一样的。在RC/RU隔离级别中，MySQL Server做了优化。在条件列没有索引的情况下，尽管通过聚簇索引来扫描全表，进行全表加锁。但是，MySQL Server层会进行过滤并把不符合条件的锁当即释放掉，因此你看起来最终结果是一样的。但是RC/RU+条件列非索引比本例多了一个释放不符合条件的锁的过程！
```

> 3) RC/RU+条件列是非聚簇索引

```
我们在num列上建上非唯一索引。此时有一棵聚簇索引(主键索引，pId)形成的B+索引树，其叶子节点为硬盘上的真实数据。以及另一棵非聚簇索引(非唯一索引，num)形成的B+索引树，其叶子节点依然为索引节点，保存了num列的字段值，和对应的聚簇索引。

这点可以看看我的《MySQL(Innodb)索引的原理》。

接下来分析开始

(1)select * from table where num = 200
不加任何锁，是快照读。
(2)select * from table where num > 200
同(1)
(3)select * from table where num = 200 lock in share mode
当num = 200，由于num列上有索引，因此先在 num = 200的两条索引记录上加行级S锁。接着，去聚簇索引树上查询，这两条记录对应的pId=2，7，因此在pId=2，7的聚簇索引上加行级S锁，采用当前读。
(4)select * from table where num > 200 lock in share mode
当num > 200，由于num列上有索引，因此先在符合条件的 num = 300的一条索引记录上加行级S锁。接着，去聚簇索引树上查询，这条记录对应的pId=3，因此在pId=3的聚簇索引上加行级S锁，采用当前读。
(5)select * from table where num = 200 for update
当num = 200，由于num列上有索引，因此先在 num = 200的两条索引记录上加行级X锁。接着，去聚簇索引树上查询，这两条记录对应的pId=2，7，因此在pId=2，7的聚簇索引上加行级X锁，采用当前读。
(6)select * from table where num > 200 for update
当num > 200，由于num列上有索引，因此先在符合条件的 num = 300的一条索引记录上加行级X锁。接着，去聚簇索引树上查询，这条记录对应的pId=3，因此在pId=3的聚簇索引上加行级X锁，采用当前读。
```

> 4) RR/Serializable+条件列非索引

```
RR级别需要多考虑的就是gap lock。本例的加锁特征在于，无论你怎么查都是锁全表。如下所示

接下来分析开始

(1)select * from table where num = 200
在RR级别下，不加任何锁，是快照读。
在Serializable级别下，在pId = 1,2,3,7（全表所有记录）的聚簇索引上加S锁。并且在
聚簇索引的所有间隙(-∞,1)(1,2)(2,3)(3,7)(7,+∞)加gap lock
(2)select * from table where num > 200
同(1)
(3)select * from table where num = 200 lock in share mode
在pId = 1,2,3,7（全表所有记录）的聚簇索引上加S锁。并且在
聚簇索引的所有间隙(-∞,1)(1,2)(2,3)(3,7)(7,+∞)加gap lock
(4)select * from table where num > 200 lock in share mode
同(3)
(5)select * from table where num = 200 for update
在pId = 1,2,3,7（全表所有记录）的聚簇索引上加X锁。并且在
聚簇索引的所有间隙(-∞,1)(1,2)(2,3)(3,7)(7,+∞)加gap lock
(6)select * from table where num > 200 for update
同(5)
```

> 5) RR/Serializable+条件列是聚簇索引

```
恩，大家应该知道pId是主键列，因此pId用的就是聚簇索引。本例的加锁特征在于，如果where后的条件为精确查询(=的情况)，那么只存在record lock。如果where后的条件为范围查询(>或<的情况)，那么存在的是record lock+gap lock。

(1)select * from table where pId = 2
在RR级别下，不加任何锁，是快照读。
在Serializable级别下，是当前读，在pId=2的聚簇索引上加S锁，不存在gap lock。
(2)select * from table where pId > 2
在RR级别下，不加任何锁，是快照读。
在Serializable级别下，是当前读，在pId=3,7的聚簇索引上加S锁。在(2,3)(3,7)(7,+∞)加上gap lock
(3)select * from table where pId = 2 lock in share mode
是当前读，在pId=2的聚簇索引上加S锁，不存在gap lock。
(4)select * from table where pId > 2 lock in share mode
是当前读，在pId=3,7的聚簇索引上加S锁。在(2,3)(3,7)(7,+∞)加上gap lock
(5)select * from table where pId = 2 for update
是当前读，在pId=2的聚簇索引上加X锁。
(6)select * from table where pId > 2 for update
在pId=3,7的聚簇索引上加X锁。在(2,3)(3,7)(7,+∞)加上gap lock
(7)select * from table where pId = 6 [lock in share mode|for update]
注意了，pId=6是不存在的列，这种情况会在(3,7)上加gap lock。
(8)select * from table where pId > 18 [lock in share mode|for update]
注意了，pId>18，查询结果是空的。在这种情况下，是在(7,+∞)上加gap lock。
```

> 6) RR/Serializable+条件列是非聚簇索引
```
这里非聚簇索引，需要区分是否为唯一索引。因为如果是非唯一索引，间隙锁的加锁方式是有区别的。

先说一下，唯一索引的情况。如果是唯一索引，情况和RR/Serializable+条件列是聚簇索引类似，唯一有区别的是:这个时候有两棵索引树，加锁是加在对应的非聚簇索引树和聚簇索引树上！大家可以自行推敲!

下面说一下，非聚簇索引是非唯一索引的情况，他和唯一索引的区别就是通过索引进行精确查询以后，不仅存在record lock，还存在gap lock。而通过唯一索引进行精确查询后，只存在record lock，不存在gap lock。老规矩在num列建立非唯一索引

(1)select * from table where num = 200
在RR级别下，不加任何锁，是快照读。
在Serializable级别下，是当前读，在pId=2，7的聚簇索引上加S锁，在num=200的非聚集索引上加S锁，在(100,200)(200,300)加上gap lock。
(2)select * from table where num > 200
在RR级别下，不加任何锁，是快照读。
在Serializable级别下，是当前读，在pId=3的聚簇索引上加S锁，在num=300的非聚集索引上加S锁。在(200,300)(300,+∞)加上gap lock
(3)select * from table where num = 200 lock in share mode
是当前读，在pId=2，7的聚簇索引上加S锁，在num=200的非聚集索引上加S锁，在(100,200)(200,300)加上gap lock。
(4)select * from table where num > 200 lock in share mode
是当前读，在pId=3的聚簇索引上加S锁，在num=300的非聚集索引上加S锁。在(200,300)(300,+∞)加上gap lock。
(5)select * from table where num = 200 for update
是当前读，在pId=2，7的聚簇索引上加S锁，在num=200的非聚集索引上加X锁，在(100,200)(200,300)加上gap lock。
(6)select * from table where num > 200 for update
是当前读，在pId=3的聚簇索引上加S锁，在num=300的非聚集索引上加X锁。在(200,300)(300,+∞)加上gap lock
(7)select * from table where num = 250 [lock in share mode|for update]
注意了，num=250是不存在的列，这种情况会在(200,300)上加gap lock。
(8)select * from table where num > 400 [lock in share mode|for update]
注意了，pId>400，查询结果是空的。在这种情况下，是在(400,+∞)上加gap lock。
```

总结一下：
   
     1、RU/RC级别在条件列非索引情况下，正常的select是快照读，即不加锁；lock in share mode会找出符合的记录的聚簇索引加行级读锁；for update会在符合条件的记录的聚簇索引加行级写锁。

     
     2、RU/RC级别在条件列聚簇索引情况下，正常的select是快照读，即不加锁；lock in share mode会找出符合的记录的聚簇索引加行级读锁；for update会在符合条件的记录的聚簇索引加行级写锁。最终加锁效果和条件列非索引一致，但【条件列非索引】多了一步扫描全表筛选符合记录的步骤。   
     
     3、RU/RC级别在条件列非聚簇索引，即普通索引情况下，正常的select是快照读，即不加锁；lock in share mode会找出符合的记录的聚簇索引加行级读锁；for update会在符合条件的记录的聚簇索引加行级写锁。最终加锁效果和条件列非索引一致，但多了一步通过索引去找聚簇索引的筛选符合记录的步骤。
     
     4、RR+条件列非索引，普通select都是快照读，即不加锁；lock in share mode会找出符合的记录的聚簇索引加行级读锁，并会在聚簇索引的所有间隙加上间隙锁，即造成整个表锁住的效果；for update会找出符合的记录的聚簇索引加行级写锁，并会在聚簇索引的所有间隙加上间隙锁，即造成整个表锁住的效果； 
     
     5、RR+条件列是聚簇索引，普通select都是快照读，即不加锁；lock in share mode会找出符合的记录的聚簇索引加行级读锁，不会加间隙锁；for update会找出符合的记录的聚簇索引加行级写锁，不会加间隙锁；
     
     
     
     
#### 5、一些注意问题

> 1）、“表锁”
  
    并不是用表锁来实现锁表的操作，而是利用了Next-Key Locks，也可以理解为是用了行锁+间隙锁来实现锁表的操作!