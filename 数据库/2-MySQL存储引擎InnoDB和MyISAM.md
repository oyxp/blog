     InnoDB和MyISAM区别 
        1、InnoDB支持事务、外键和崩溃后的安全恢复，而MyISAM是不支持事务、外键以及崩溃后的安全恢复
        
        2、InnoDB支持行锁，MyISAM是不支持行锁。
        
        3、InnoDB适用于写多读少、读多写多的情况，而MyISAM则适用于读多写少的情况，一般情况下都是用InnoDB引擎。
        
        4、InnoDB数据在mysql5.6.6版本以前是存储在共享表空间，但可通过配置innodb_file_per_table更改，5.6.6版本后默认开启，将数据和索引存储在独立的ibd文件；而MyISAM是将数据和索引存储在myi(索引)文件和myd(数据)文件。
        
        5、InnoDB对于主键的查询性能会比MyISAM高
        
        6、MyISAM支持全文索引（只能对英文进行检索），而InnoDB不支持