#



## 1、架构

![docker](./art.png)

## 2、底层技术

    容器=cgroup+namespace+rootfs+容器引擎(用户态工具LXC)
    
    Cgroup（资源控制）
    Namespace（访问隔离）
    rootfs（文件系统隔离）
    容器引擎（生命周期控制）