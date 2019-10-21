# MySQL SQL语句性能优化

## 1、查找分析SQL执行慢的方法
    
    1）：记录慢日志，然后使用mysqldumpslow或者pt-query-digest分析SQL

    2）：使用show profiles.通过set profiling=1;来开启，会记录所有SQL语句执行消耗的时间，并存储到临时表中。
      show profiles:查看临时表
      show profile query for 【ID】：查看某个语句耗时详情
      
    3）：show [global ] status；会返回一些计数器，有些情况下可以看出哪些操作消耗时间多或者占性能高
    
    4）：show processlist;可以用查看出有问题的进程
    
    
## 2、通用优化查询方法
   
     1）只查询出需要返回的列字段数据
     2）重复查询相同的数据，可以使用缓存（file，redis，memorycache）
     3）使用explain来分析SQL语句，适当的进行加索引优化
     4）字段冗余，使用空间换取时间
     5）连表查询时，小表驱动大表
     5）可以将大的查询分割成小查询，减少连表
     
     select count(*):做缓存、专门使用一张统计行数的表，每次更新时随机选取一条记录修改num数，总数就是所有记录的num总和
     
     6）union all代替union，union all性能更高，因为结果不用去重
     7）大表limit分页，加组合索引（where字句所有列,order使用的列），或者假如ID列是整数自增类型，那么可以先计算出上次分页后的id值，查询时使用>id limit
     8）分区分表
     9）修改MySQL配置，合理增加查询缓存
    
## 3、explain分析并优化sql语句（神器）
> 关注指标 type、key、rows以及extra。通过分析sql性能进行优化
        
        