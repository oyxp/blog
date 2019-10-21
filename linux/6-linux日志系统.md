#Linux日志系统

##1、日志服务简介 
>在Linux系统中，日志服务是由rsyslogd服务提供的，我们先来查看这个日志服务是否启动和自启动 

![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180314/c26de3bbc02fcdaa09d291766e31d970.jpg)


>该服务是由系统管理，开机自启。可以使用service命令管理该服务

 `service rsyslog start|stop|restart`

##2、常见日志文件及其作用
|  日志文件 | 作用  |
| ------------ | ------------ |
|  `/var/log/cron.log` |  crontab命令（系统定时任务）产生的日志文件 |
| `/var/log/cups`  | 记录打印信息的日志  |
| `/var/log/dmesg`  |记录系统在开机时自检的信息，可以直接使用```dmesg```命令查看内核自检信息   |
|`/var/log/btmp`   |  记录错误登录的日志，二进制文件，不能直接查看，需要使用```lastb```命令查看 <br/>![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180314/8ff93d3332079c7dd343ff50ce6a3b1c.jpg)|
| `/var/log/lastlog`  |  记录系统中所有用户最后一次登录系统时间的日志，二进制文件，需要使用```lastlog```命令查看<br/>![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180314/5c1205991ee86447304f9424301a0419.jpg) |
| `/var/log/mailog`  |  记录系统邮件信息 |
|`/var/log/message`   | 记录系统重要信息的日志，绝大多数重要信息都会存在该日志文件中，系统出问题时可以检查该文件  |
| `/var/log/secure`  |记录验证和授权方面的信息，只要涉及到账户和密码的程序都会记录。例如ssh登录，su切换用户，sudo授权。甚至添加用户和修改用户密码都会出现该文件中   |
| `/var/log/wtmp`  |  永久记录所有用户的登录、注销信息，同时记录系统的启动、重启和关机事件，二进制文件，需要使用```last```命令查看 |
| `/var/log/utmp`  |  记录当前用户已经登录的用户信息。这个文件会随着用户的登录和注销不断变化，只记录当前登录用户的信息，二进制文件，可使用```w```、``who``、`users`等命令来查询 |

##3、rsyslogd服务
1）、日志文件格式
>基本日志格式包含以下四列： 

>事件产生的时间 
发生事件的服务器主机名 
产生事件的服务名或程序名 
事件的具体信息

2)、`/etc/rsyslog.d/50-default.conf` (Ubuntu)
 
 ![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180314/6934a8f2f944b34eafae5c03137b1ec8.jpg)
 
| 服务名  |  说明 |
| ------------ | ------------ |
| auth  |  安全与认证相关消息 |
| authpriv |  私有的安全与认证相关消息 |
| cron  |  系统定时任务cron和at产生的日志 |
| daemon  | 和各个守护进程相关的日志  |
| ftp  | ftp守护进程产生的日志  |
| kern  | 内核产生的日志  |
| local0-local7  | 为本地预留的服务日志  |
| lpr  | 打印产生的日志  |
| mail  | 邮件收发信息  |
| news  | 与新闻服务器相关的日志  |
| syslog  | syslogd服务产生的日志（虽然服务名改为rsyslogd，但多数配置延用syslogd）  |
| user  |  用户等级类别的日志 |
| uucp  | uucp子系统的日志信息，早期linux进行数据传递的协议  |
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180314/60318da7ece0fd0b7e00568bb8d1e9ab.jpg)
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180314/ba7019d8a53c47af218c43dfcce927af.jpg)
##4、日志轮替
>我们知道，不管是系统服务日志还是RPM包安装或者源码包安装的服务，都不可能一直保存在我们的服务器，这样的话，总有一天，服务器的存储空间会不够，这就需要在一定的时间把旧的日志文件删掉，只保留一定数量的日志文件，日志轮替就是做这件事的 
日志轮替规则在配置文件/etc/logrotate.conf /etc/logrotate.d中 

/etc/logrotate.conf里面参数的具体含义 

| 参数  |  说明 |
| ------------ | ------------ |
|daily	|日志的轮换周期是每天|
|weekly	|日志的轮换周期是每周|
|monthly	|日志的轮换周期是每月|
|rotate 数字	|保留的日志文件的个数，0指没有备份|
|compress	|日志轮替时，旧的日志进行压缩|
|create mode owner group 	|新建新日志，同时指定新日志的权限与所有者和所属组，如`create 0600 root  utmp`|
|mail address	|日志轮替时，输出内容通过邮件发送到指定的邮件地址，如`mail hb@163.com`|
|missingok	|如果日志不存在，则忽略该日志的警告信息|
|notifempty	|如果日志为空，则不进行日志轮替|
|minsize 大小	|日志轮替的最小值，日志一定要达到最小值才会轮替，否则到时间也不轮替|
|size 大小	|日志只有大于指定大小才进行日志轮替，而不是按时间轮替，如 `size 100k`|
|dateext	|使用日期作为日志轮替的后缀，如`log-20140101`|


##5、将redis日志添加到日志轮替


```bash
   /var/log/redis/redis1*.log {
        weekly
        missingok
        rotate 12
        compress
        notifempty
   }
   
    /usr/local/apache2/logs/access_log {
        daily
        create 
        rotate  30
}
```

##6、logrotate 命令

       logrotate [选项] [配置文件名]

        如果此命令没有选项，则会按照配置文件中的条件进行日志轮替

       -v ：显示日志轮替过程，加了-v ，会显示日志的轮替的过程

       -f  ： 强制进行日志轮替，不管日志轮替的条件是否已经符合，强制配置文件的所有的日志进行轮替



