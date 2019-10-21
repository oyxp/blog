#Lnux系统管理-PS

##1、ps和pstree命令

查看它的man手册可以看到，`ps`命令能够给出当前系统中进程的快照。它能捕获系统在某一事件的进程状态。如果你想不断更新查看的这个状态，可以使用`top`命令。

ps命令支持三种使用的语法格式

1. UNIX 风格，选项可以组合在一起，并且选项前必须有“-”连字符
2. BSD 风格，选项可以组合在一起，但是选项前不能有“-”连字符
3. GNU 风格的长选项，选项前有两个“-”连字符

####1)、 不加参数执行ps命令
这是一个基本的 ps 使用。在控制台中执行这个命令并查看结果。
```bash
ps
```
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/44bb6bcb6b86907c621267ea3ac19bb6.jpg)

结果默认会显示4列信息。

- PID: 运行着的命令(CMD)的进程编号ID
- TTY: 命令所运行的位置（终端）
- TIME: 运行着的该命令所占用的CPU处理时间
- CMD: 该进程所运行的命令

其他列信息：
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/0e69826fb0aa59622aaf0e05147ecf31.jpg)
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/69ae0c361a078a117ade97003b58455c.jpg)

####2). 显示所有当前进程
使用 `-a` 参数。`-a` 代表 `all`。同时加上`x`参数会显示`没有控制终端`的进程。这个命令的结果或许会很长。为了便于查看，可以结合less命令和管道来使用
```bash
ps -ax | less
```
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/29e6c186044e68e102bca2f1d2447f6f.jpg)

####3)、根据用户过滤进程
使用`-u`参数.在需要查看特定用户进程的情况下，我们可以使用 `-u` 参数。比如我们要查看用户`root`的进程，可以通过下面的命令：
```bash
ps -u root
```
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/c94a913dfc05786b413393b9b4703afe.jpg)

####4)、 通过cpu和内存使用来过滤进程
把结果按照 `CPU` 或者`内存`用量来筛选，可以使用 `aux` 参数，来显示全面的信息:
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/7ec6690c9e573ac9c4e243a58a464f1d.jpg)

默认的结果集是未排好序的。可以通过 `--sort`命令来排序。
根据 `内存` 使用来升序排序
```bash
ps -aux --sort -pcpu | head -n 10
```
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/d77d72dc98f5f084bdc4f466e1bc03dc.jpg)

可以看出Elastic服务占用内存最高

根据CPU使用率来排序
```bash
ps -aux --sort -pcpu | head -n 10
```

CPU使用率升序(-p)、内存占用降序(+p 高->低)
```bash
ps -aux --sort -pmem,+pcpu | head -n 10
```
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/6be97950da848f13ecbfba83fda29ba7.jpg)


####5)、结合watch命令监控
```bash
watch -n 1 'ps -aux --sort -pmem,-pcpu | head -n 20'
```
![](https://www.ouyangxiaoping.com:8888/data/upload/assets/20180315/031947d2e17dcd8eb9e16d8e3a2ef3d5.jpg)


##常用参数总结

```bash
   -a :显示一个终端的所有进程，除了会话引线
   -u ：显示指定用户的进程
   -x :显示没有控制终端的进程
   -l ：长格式显示，显示更加详细的信息
   -f :显示格式化的信息
   -e ：显示所有进程，和-A作用一致
```



