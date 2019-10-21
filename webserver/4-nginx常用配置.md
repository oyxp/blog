### Nginx常用配置

#### 1、SSL配置

- 单个server配置HTTPS
```
server {
    listen              443 ssl;
    ssl_certificate   sslkey/bocaidj.com.pem;
    ssl_certificate_key  sslkey/bocaidj.com.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols    TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;
    server_name test.com;
}
```
- 多个severName配置HTTPS
```
ssl_certificate     common.crt;
ssl_certificate_key common.key;

server {
    listen          443 ssl;
    server_name     www.example.com;
    ...
}

server {
    listen          443 ssl;
    server_name     www.example.org;
    ...
}
```

#### 2、rewrite规则

      rewrite ... last:rewrite之后再重新匹配location一次
      rewrite ... break:rewrite之后在当前location执行
     
```
server {
   location / {
      if (!-e $request_filename){
         rewrite ^/(.*)$ /index.php/$1 last;
      }
   }
}
```

#### 3、反向代理

```
upstream test.com {
  server 127.0.0.1:8080;
  server 192.168.1.1:9090;
}
server {
   location / {
        proxy_pass http://test.com;
    }
}
```
常用的proxy配置

```
proxy_redirect default;
proxy_set_header X-Real-IP $remote_addr;
proxy_set_header X-Forwarded-For $remote_addr;

proxy_connect_timeout 30;
proxy_send_timeout 60;
proxy_read_timeout 60;

proxy_buffer_size 32k;
proxy_buffering on;
proxy_buffers 4 128k;
proxy_busy_buffers_size 256k;
proxy_max_temp_file_size 256k;
proxy_next_upstream error timeout invalid_header http_500 http_502 http_503 http_504 http_404;
```

#### 4、负载均衡
- 基于 weight 权重的负载
```
upstream webservers{
    server 192.168.33.11 weight=10;
    server 192.168.33.12 weight=10;
    server 192.168.33.13 weight=10;
}
server {
    listen 80;
    server_name upstream.com;
    access_log /var/log/nginx/upstream.access.log main;
    error_log /var/log/nginx/upstream.error.log error;
    location / {
        proxy_pass http://webservers;
        proxy_set_header  X-Real-IP  $remote_addr;
    }
}
```
  
     max_fails : 允许请求失败的次数，默认为1。当超过最大次数时，返回proxy_next_upstream 模块定义的错误。

    fail_timeout : 在经历了max_fails次失败后，暂停服务的时间。max_fails可以和fail_timeout一起使用，进行健康状态检查。

 ```
upstream webservers{
    server 192.168.33.11 weight=10 max_fails=2 fail_timeout=30s;
    server 192.168.33.12 weight=10 max_fails=2 fail_timeout=30s;
    server 192.168.33.13 weight=10 max_fails=2 fail_timeout=30s;
}
 ```
 
     down 表示这台机器暂时不参与负载均衡。相当于注释掉了。

     backup 表示这台机器是备用机器，是其他的机器不能用的时候，这台机器才会被使用，俗称备胎
     
     
 ```
 upstream webservers{
    server 192.168.33.11 down;
    server 192.168.33.12 weight=10 max_fails=2 fail_timeout=30s;
    server 192.168.33.13 backup;
}
 ```  
 
 #### 5、页面缓存
 
> 页面缓存也是日常web 开发中很重要的一个环节，对于一些页面，我们可以将其静态化，保存起来，下次请求时候，直接走缓存，而不用去请求反相代理服务器甚至数据库服务了。从而减轻服务器压力。

> nginx 也提供了简单而强大的下重定向，反向代理的缓存功能，只需要简单配置下，就能将指定的一个页面缓存起来。它的原理也很简单，就是匹配当前访问的url, hash加密后，去指定的缓存目录找，看有没有，有的话就说明匹配到缓存了。

**一个简单的页面缓存的配置：**

```http {
  proxy_cache_path /data/nginx/cache levels=1:2 keys_zone=cache_zone:10m inactive=1d max_size=100m;
  upstream myproject {
    .....
  }
  server  {
    ....
    location ~* \.php$ {
        proxy_cache cache_zone; #keys_zone的名字
        proxy_cache_key $host$uri$is_args$args; #缓存规则
        proxy_cache_valid any 1d;
        proxy_pass http://127.0.0.1:8080;
    }
  }
  ....
}
```
> 用到的配置参数，主要是proxy_*前缀的很多配置。
首先需要在http中加入proxy_cache_path 它用来制定缓存的目录以及缓存目录深度制定等。它的格式如下：


    proxy_cache_path path [levels=number] keys_zone=zone_name:zone_size [inactive=time] [max_size=size]; 
- 1. path是用来指定 缓存在磁盘的路径地址。比如：/data/nginx/cache。那以后生存的缓存文件就会存在这个目录下。

- 2. levels用来指定缓存文件夹的级数，可以是：levels=1, levels=1:1, levels=1:2, levels=1:2:3 可以使用任意的1位或2位数字作为目录结构分割符，如 X, X:X,或 X:X:X 例如: 2, 2:2, 1:1:2，但是最多只能是三级目录。

> 那这个里面的数字是什么意思呢。表示取hash值的个数。比如：现在根据请求地址localhost/index.php?a=4 用md5进行哈希，得到e0bd86606797639426a92306b1b98ad9

> levels=1:2 表示建立2级目录，把hash最后1位(9)拿出建一个目录，然后再把9前面的2位(ad)拿来建一个目录, 那么缓存文件的路径就是/data/nginx/cache/9/ad/e0bd86606797639426a92306b1b98ad9

> 以此类推：levels=1:1:2表示建立3级目录，把hash最后1位(9)拿出建一个目录，然后再把9前面的1位(d)建一个目录, 最后把d前面的2位(8a)拿出来建一个目录 那么缓存文件的路径就是/data/nginx/cache/9/d/8a/e0bd86606797639426a92306b1b98ad9

- 3. keys_zone 所有活动的key和元数据存储在共享的内存池中，这个区域用keys_zone参数指定。one指的是共享池的名称，10m指的是共享池的大小。

注意每一个定义的内存池必须是不重复的路径，例如：
```
proxy_cache_path  /data/nginx/cache/one  levels=1      keys_zone=one:10m;
proxy_cache_path  /data/nginx/cache/two  levels=2:2    keys_zone=two:100m;
proxy_cache_path  /data/nginx/cache/three  levels=1:1:2  keys_zone=three:1000m;
```
- 4. inactive 表示指定的时间内缓存的数据没有被请求则被删除，默认inactive为10分钟。inactive=1d 1小时。inactive=30m30分钟。

- 5. max_size 表示单个文件最大不超过的大小。它被用来删除不活动的缓存和控制缓存大小，当目前缓存的值超出max_size指定的值之后，超过其大小后最少使用数据（LRU替换算法）将被删除。max_size=10g表示当缓存池超过10g就会清除不常用的缓存文件。

- 6. clean_time 表示每间隔自动清除的时间。clean_time=1m 1分钟清除一次缓存

**在server模块里的几个配置参数：**

> proxy_cache 用来指定用哪个keys_zone的名字，也就是用哪个目录下的缓存。上面我们指定了三个one, two,three 。比如，我现在想用one 这个缓存目录 : proxy_cache one

> proxy_cache_key 这个其实蛮重要的，它用来指定生成hash的url地址的格式。他会根据这个key映射成一个hash值，然后存入到本地文件。 
proxy_cache_key $host$uri表示无论后面跟的什么参数，都会访问一个文件，不会再生成新的文件。 
而如果proxy_cache_key $is_args$args，那么传入的参数 localhost/index.php?a=4 与localhost/index.php?a=44将映射成两个不同hash值的文件。

> proxy_cache_key 默认是 "\$scheme\$host\$request_uri"。但是一般我们会把它设置成：\$host\$uri\$is_args$args 一个完整的url路径。

> proxy_cache_valid 它是用来为不同的http响应状态码设置不同的缓存时间,

    proxy_cache_valid  200 302  10m;
    proxy_cache_valid  404      1m;
    表示为http status code 为200和302的设置缓存时间为10分钟，404代码缓存1分钟。 
>如果只定义时间：

    proxy_cache_valid 5m;
    那么只对代码为200, 301和302的code进行缓存。 
> 同样可以使用any参数任何相响应：

    proxy_cache_valid  200 302 10m;
    proxy_cache_valid  301 1h;
    proxy_cache_valid  any 1m; #所有的状态都缓存1小时

> proxy_cache.conf 文件:

```
proxy_cache_path /var/cache levels=1:2 keys_zone=cache_zone:10m inactive=1d max_size=100m;
server  {
    listen 80;
    server_name cache.com;
    access_log /usr/local/var/log/nginx/cache.access.log main;
    error_log /usr/local/var/log/nginx/cache.error.log error;
    add_header X-Via $server_addr;
    add_header X-Cache $upstream_cache_status;
    location / {
        proxy_set_header  X-Real-IP  $remote_addr;
        proxy_cache cache_zone;
        proxy_cache_key $host$uri$is_args$args;
        proxy_cache_valid 200 304 1m;
        proxy_pass http://192.168.33.11;
    }
}
```
当然缓存文件夹 /var/cache得提前新建好。然后重启nginx。

打开审核元素看network网络请求选项，我们可以看到，Response Headers，在这里我们可以看到：

X-Cache:MISS
X-Via:127.0.0.1
X-cache 为 MISS 表示未命中，请求被传送到后端。y因为是第一次访问，没有缓存，所以肯定是未命中。我们再刷新下，就发现其变成了HIT, 表示命中。它还有其他几种状态：

     MISS 未命中，请求被传送到后端 
     HIT 缓存命中 
     EXPIRED 缓存已经过期请求被传送到后端 
     UPDATING 正在更新缓存，将使用旧的应答 
     STALE 后端将得到过期的应答 
     BYPASS 缓存被绕过了

缓存文件夹 /var/cache里
已经生成了缓存文件。

#### 6、图片缓存服务

```
server {
    index index.php index.html index.htm;
    listen 443 ssl;
    listen 80;
    ssl_certificate   sslkey/bocaidj.com.pem;
    ssl_certificate_key  sslkey/bocaidj.com.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols    TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;
    server_name imagick.bocaidj.com;
    if ( $scheme = 'http' ) {
       return 301 https://$host$request_uri;
    }
    client_max_body_size 100m;
    #set log format
    access_log /var/log/nginx/imagick.bocaidj.com.access.log access;
    error_log  /var/log/nginx/imagick.bocaidj.com.error.log;

      location / {
                try_files $uri $uri/ =404;
        }
               #handle jpg jpeg png gif
       location ~ \.(jpg|jpeg|png|gif)$ {
                proxy_store on;//开启缓存
                proxy_store_access user:rw group:rw all:r;//缓存权限,user当前用户读写，group同组用户读写，all所有用户可读
                root /data/imagick.bocaidj.com/cache;//存放路径
                proxy_temp_path /data/imagick.bocaidj.com/cache;//存放路径
                expires 1d;//过期时间


              proxy_set_header Host 'imagick.bocaidj.com';
           
           
           
           //当图片不存在时，就去请求真实服务器
              if ( !-e $request_filename ) {
                 proxy_pass http://bocaidj.com;
              }
      }
```

#### 7、websocket服务代理配置

```
server{
    listen 9501 ssl;
    ssl_certificate   sslkey/bocaidj.com.pem;
    ssl_certificate_key  sslkey/bocaidj.com.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;
    server_name mc.bocaidj.com;
    client_max_body_size 100m;
    access_log /var/log/nginx/mc.bocaidj.com.access.log access;
    error_log  /var/log/nginx/mc.bocaidj.com.error.log;
          location / {
            proxy_pass http://mc.bocaidj.com;//后端实际websocket服务器
            proxy_http_version 1.1;
            proxy_set_header Upgrade $http_upgrade;//设置Upgrade头
            proxy_set_header Connection "upgrade";//
            proxy_set_header X-real-ip $remote_addr;//方便获取实际IP
            proxy_set_header X-Forwarded-For $remote_addr;//方便获取实际IP
         }

}
```


#### 8、防盗链
```
有效的referer设置：

valid_referers none | blocked | server_name | string...

blocked:代理、防火墙删除了referer情况
```

```
location ~* .*\.(jpg|jpeg|gif|tar|png|zip)${

   valid_referers none blocked *.com;
   if ($invalid_referer) {
       return 403;
   }

}
```

#### 9、Nginx设置上传文件大小限制
> 设置 client_max_body_size的大小即可，可以在http、server和location节点中设置
```
 server
        {
           listen 80;
           server_name test.net;
           root  /var/www/test;
           client_max_body_size 100m;
           location ~ [^/]\.php(/|$)
             {
                include        fastcgi_params;
                fastcgi_pass   127.0.0.1:9000;
                fastcgi_index  index.php;
                client_max_body_size  500m;
             }
        }
```

> 如果是php，也需要修改php.ini配置文件

```ini

  ; Maximum allowed size for uploaded files.
  ; http://php.net/upload-max-filesize
  upload_max_filesize = 2M //上传文件大小


  ; Maximum size of POST data that PHP will accept.
  ; Its value may be 0 to disable the limit. It is ignored if POST data reading
  ; is disabled through enable_post_data_reading.
  ; http://php.net/post-max-size
  post_max_size = 8M //post data大小
```

