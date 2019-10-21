# Nginx

## 1、概念

     master/worker多进程模型
     
## 2、启动流程
      
      

## 3、master职责

     负责管理worker进程（如启动、停止或重启worker）、解析并读取配置；

## 4、worker职责

     接收和处理来自客户端的连接；worker进程之间是相互独立的，不会互相影响；单线程
     
## 5、常见配置

    