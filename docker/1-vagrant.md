# vagrant

## 1、vagrant
> vagrant是一款可以帮助快速搭建虚拟环境的工具，配合virtualbox和vm workstation使用.
可以免去下载镜像使用vb或vm直接安装，非常方便。也非常方便迁移环境。适用开发环境。


## 2、常用命令

    vagrant box list : 列出当前所有虚拟机
    vagrant box add 名字 [url]：添加虚拟机
    vagrant init 名字 ： 在当前目录下初始化，会创建一个Vagrantfile配置文件
    vagrant up：启动当前目录下的虚拟机
    vagrant halt：停止当前虚拟机
    vagrant status：查看当前虚拟机状态
    vagrant destory：删除当前虚拟机
    vagrant package --output 导出包名： 用于导出当前虚拟机，可以供别人使用
    vagrant ssh: 登录虚拟机
    
# 3、`Vagrantfile`配置文件解析    
> 样例
    
```ini
# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "centos/7" 

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  # config.vm.provider "virtualbox" do |vb| #配置虚拟机
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true #是否使用gui
  #
  #   # Customize the amount of memory on the VM:
  #   vb.memory = "1024" #内存大小
  # end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  # config.vm.provision "shell", inline: <<-SHELL
  #   apt-get update
  #   apt-get install -y apache2
  # SHELL
end
``` 

      config.vm.box = "centos/7" #设置当前虚拟机使用的镜像
      config.vm.network "forwarded_port", guest: 80, host: 8080 # 端口转发配置，将宿主机host的端口与虚拟机的端口对应
      config.vm.network "private_network", ip: "192.168.33.10" #创建host-only网络
      config.vm.network "public_network", ip: "局域网IP" #使用桥接网络，局域网调通机器可以访问
      config.vm.synced_folder "../data", "/vagrant_data" # 共享文件夹配置，将宿主机的../data目录挂载到虚拟机的/vagrant_data目录
      
      
      config.vm.provision "shell", inline: <<-SHELL
      SHELL  #配置安装虚拟机需要执行的shell命令
      