# Dockerfile语法
> 通过Dockerfile构建自己的镜像

## 1、 `FROM`
> 指定基础镜像，表示从该基础镜像开始构建新的镜像

    FROM scratch #表示制作base image基础镜像，无任何依赖时使用
    FROM centos  #使用base image
    FROM ubuntu:16.04  #使用base image,指定tag版本，如未指定tag，表示使用latest版本
    
    
    
## 2、 `LABEL`
> 标签，用来说明信息，比如维护人、版本和描述,类似注释

    
    LABEL maintainer="snail@qq.com"
    LABEL version="1.0"
    LABEL description="test"
            
## 3、`RUN` 
> 执行shell命令，每执行RUN会生成新的一层，尽量将命令合并一起，避免无用分层

    RUN apt-get update && apt-get install php  #多行可以使用\换行
    
## 4、`WORKDIR`
> 指定工作目录，类似shell中的cd命令。如果目录不存在，则会自动创建。尽量使用绝对路径。


    WORKDIR  /root
    RUN pwd  # /root
    
    WORKDIR /root
    WORKDIR demo
    RUN pwd # /root/demo
      

## 5、`ADD` `COPY`    
> 都是将本地文件复制到容器中。ADD命令会添加文件并自动加压缩。大部分情况下COPY会优先于ADD，远程文件使用curl或wget。

     ADD 本地文件  容器文件
     COPY 本地文件  容器文件
         
     ADD  test.tar.gz  /root #复制到/root并自动解压
    
## 6、`ENV`
> 设定环境变量，可以增加维护性

    ENV  MYSQL_PWD 123456
    
## 7、`VOLUME`
> 文件挂载，文件存储


## 8、`EXPOSE`
> 端口暴露规则，网络


## 9、`CMD`和`ENTRYPOINT`    
> CMD：容器启动时默认执行的命令
> ENTRYPOINT: 容器启动时要执行的命令

  
- shell格式
   
      将要执行的命令当成shell来执行
      RUN apt-get update
      CMD apt-get update
      ENTRYPOINT apt-get update
    
      
- exec格式
 
      将要执行的命令分拆成一定格式来执行
       
     RUN ["apt-get","install","-y","php"]           
     CMD ["apt-get","install","-y","php"]           
     ENTRYPOINT ["/bin/bash","-c","apt-get install -y php"]  
     
     
- CMD和ENTRYPOINT区别

     
     CMD
       1、容器启动时默认执行的命令 
       2、docker run时指定了其他命令，CMD命令会被忽略     
       3、多个CMD命令只会执行最后一个
       
     Dockerfile:
         FROM centos
         ENV name docker
         CMD echo $name
         
      docker run image_name:  docker
      docker run -it image_name /bin/bash: 会忽略CMD命令，进入bash
      
      
     
     ENTRYPONIT：
        1、容器启动时执行的命令（通常是作为服务来运行）
        2、不会被忽略，一定会执行
        3、通常是以一个shell脚本作为启动脚本
        
     Dockerfile:
         FROM centos
         ENV name docker
         ENTRYPPOINT echo $name
         
      docker run image_name:  docker
      docker run -it image_name /bin/bash: 不会被覆盖，还是输出docker              
         
                   