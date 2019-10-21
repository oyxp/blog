# ssh密钥登录服务器

##1、原理

  >密钥形式登录的原理是：
      利用密钥生成器制作一对密钥：一只公钥和一只私钥。
    将公钥添加到服务``器的某个账户上，然后在客户端利用私钥即可完成认证并登录。
    这样一来，没有私钥，任何人都无法通过 SSH 暴力破解你的密码来远程登录到系统。
    此外，如果将公钥复制到其他账户甚至主机，利用私钥也可以登录
    
    
##2、在服务器上制作密钥对

       
     ssh-keygen -t rsa -b 4096   
     root@snail:~# ssh-keygen -t rsa  -b 4096
     Generating public/private rsa key pair.
     Enter file in which to save the key (/root/.ssh/id_rsa):
     Enter passphrase (empty for no passphrase):
     Enter same passphrase again:
     Your identification has been saved in /root/.ssh/id_rsa.
     Your public key has been saved in /root/.ssh/id_rsa.pub.
    The key fingerprint is:
    SHA256:/UKL6D0OSy2nC5DPhZaf5eV3jsMedOD9olxcG0g+CWU root@snail
    The key's randomart image is:
    +---[RSA 4096]----+
    |             E   |
    |            o    |
    |           ...   |
    |   . o   . .+oo  |
    |  o + . S + o=o..|
    |   = o * = + o.oo|
    |    + B = +.+ =..|
    |     + B.  +oB . |
    |      =oo. .=..  |
    +----[SHA256]-----+
    
##3、服务器上安装公钥

    
    root@snail:~# cd .ssh/
    root@snail:~/.ssh# cat id_rsa.pub >> authorized_keys

##4、打开ssh密钥登录功能

    root@snail:~# vim /etc/ssh/sshd_config
    
    RSAAuthentication yes
    PubkeyAuthentication yes
    
    #允许root登录
    PermitRootLogin yes

    当你完成全部设置，并以密钥方式登录成功后，再禁用密码登录：

    PasswordAuthentication no
    最后，重启 SSH 服务：

    root@snail:~# service ssh restart


##5、下载私钥 id_rsa

    登录方式：
    
    ssh -i id_rsa root@www.ouyangxiaoping.com
    
    
##6、多台服务器上使用密钥登录

    将第一步生成的公钥id_rsa.pub的内容添加到服务器上的相同用户的.ssh 
    文件夹中的 authorized_keys
    
    root:   /root/.ssh/authorized_keys
    普通用户： /home/user/.ssh/authorized_keys
    chmod 600 authorized_keys
   





ssh-keygen可用的参数选项有：

     -a trials
             在使用 -T 对 DH-GEX 候选素数进行安全筛选时需要执行的基本测试数量。

     -B      显示指定的公钥/私钥文件的 bubblebabble 摘要。

     -b bits
             指定密钥长度。对于RSA密钥，最小要求768位，默认是2048位。DSA密钥必须恰好是1024位(FIPS 186-2 标准的要求)。

     -C comment
             提供一个新注释

     -c      要求修改私钥和公钥文件中的注释。本选项只支持 RSA1 密钥。
             程序将提示输入私钥文件名、密语(如果存在)、新注释。

     -D reader
             下载存储在智能卡 reader 里的 RSA 公钥。

     -e      读取OpenSSH的私钥或公钥文件，并以 RFC 4716 SSH 公钥文件格式在 stdout 上显示出来。
             该选项能够为多种商业版本的 SSH 输出密钥。

     -F hostname
             在 known_hosts 文件中搜索指定的 hostname ，并列出所有的匹配项。
             这个选项主要用于查找散列过的主机名/ip地址，还可以和 -H 选项联用打印找到的公钥的散列值。

     -f filename
             指定密钥文件名。

     -G output_file
             为 DH-GEX 产生候选素数。这些素数必须在使用之前使用 -T 选项进行安全筛选。

     -g      在使用 -r 打印指纹资源记录的时候使用通用的 DNS 格式。

     -H      对 known_hosts 文件进行散列计算。这将把文件中的所有主机名/ip地址替换为相应的散列值。
             原来文件的内容将会添加一个".old"后缀后保存。这些散列值只能被 ssh 和 sshd 使用。
             这个选项不会修改已经经过散列的主机名/ip地址，因此可以在部分公钥已经散列过的文件上安全使用。

     -i      读取未加密的SSH-2兼容的私钥/公钥文件，然后在 stdout 显示OpenSSH兼容的私钥/公钥。
             该选项主要用于从多种商业版本的SSH中导入密钥。

     -l      显示公钥文件的指纹数据。它也支持 RSA1 的私钥。
             对于RSA和DSA密钥，将会寻找对应的公钥文件，然后显示其指纹数据。

     -M memory
             指定在生成 DH-GEXS 候选素数的时候最大内存用量(MB)。

     -N new_passphrase
             提供一个新的密语。

     -P passphrase
             提供(旧)密语。

     -p      要求改变某私钥文件的密语而不重建私钥。程序将提示输入私钥文件名、原来的密语、以及两次输入新密语。

     -q      安静模式。用于在 /etc/rc 中创建新密钥的时候。

     -R hostname
             从 known_hosts 文件中删除所有属于 hostname 的密钥。
             这个选项主要用于删除经过散列的主机(参见 -H 选项)的密钥。

     -r hostname
             打印名为 hostname 的公钥文件的 SSHFP 指纹资源记录。

     -S start
             指定在生成 DH-GEX 候选模数时的起始点(16进制)。

     -T output_file
             测试 Diffie-Hellman group exchange 候选素数(由 -G 选项生成)的安全性。

     -t type
             指定要创建的密钥类型。可以使用："rsa1"(SSH-1) "rsa"(SSH-2) "dsa"(SSH-2)

     -U reader
             把现存的RSA私钥上传到智能卡 reader

     -v      详细模式。ssh-keygen 将会输出处理过程的详细调试信息。常用于调试模数的产生过程。
             重复使用多个 -v 选项将会增加信息的详细程度(最大3次)。

     -W generator
             指定在为 DH-GEX 测试候选模数时想要使用的 generator

     -y      读取OpenSSH专有格式的公钥文件，并将OpenSSH公钥显示在 stdout 上。






``