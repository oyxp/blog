# Docker的安装
> docker可以安装在windows、macos、linux等平台中。大部分docker都是安装linux环境中，也是最符合
生产环境的需求，所以推荐是在linux平台上搭建docker。这里可以借助vagrant和virtual来快速搭建虚拟机。

> docker是分社区版和企业版
## 1、windows安装docker
    
    docker官网下载windows的msi安装包，点击直接安装即可。目前只支持win10系统
    
## 2、macos安装docker

    docker官网下载mac的dmg安装包，点击安装即可

## 3、centos安装docker
> 最符合生产环境需求的环境

- 卸载之前的旧的docker版本
    
    
      sudo yum remove docker \
                        docker-client \
                        docker-client-latest \
                        docker-common \
                        docker-latest \
                        docker-latest-logrotate \
                        docker-logrotate \
                        docker-engine    
    
- 安装docker ce（社区版）


      # 安装需要的包 
      sudo yum install -y yum-utils \
         device-mapper-persistent-data \
         lvm2
      # 配置docker的yum源，添加仓库   
      sudo yum-config-manager \
          --add-repo \
          https://download.docker.com/linux/centos/docker-ce.repo  
          
      #安装
      sudo yum install docker-ce docker-ce-cli containerd.io     
      
- 启动
    
      
      sudo systemctl start docker
      sudo docker run hello-world      
      
## 4、通过docker-machine搭建docker host      
      
## 5、免费的在线docker环境

     docker playground      