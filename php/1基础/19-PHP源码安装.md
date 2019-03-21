# PHP源码安装

## 1、编译参数

     ./configure --prefix=/data/work/php7.3.3 --enable-bcmath --enable-mbstring --enable-sockets 
--enable-mysqlnd  --enable-zip --enable-soap --enable-xml --enable-mbstring --with-mysql=mysqlnd --with-curl --with-zlib --with-gd --with-openssl 
--enable-pcntl --with-mcrypt --enable-fpm

    ./configure --prefix=/data/work/php7.3.3 --with-config-file-path=/data/work/php7.3.3/etc --with-mysql-sock --with-mysqli --enable-fpm  --enable-pcntl --with-libxml-dir --with-openssl --with-mhash --with-pcre-regex  --with-zlib --enable-bcmath --with-iconv --with-bz2 --enable-calendar --with-curl --with-cdb --enable-dom --enable-exif --enable-fileinfo --enable-filter --with-pcre-dir --enable-ftp --with-gd --with-openssl-dir --with-jpeg-dir --with-png-dir --with-zlib-dir --with-freetype-dir --enable-gd-jis-conv --with-gettext --with-gmp --with-mhash --enable-json --enable-mbstring --enable-mbregex  --enable-pdo --with-pdo-mysql --with-zlib-dir --with-readline --enable-session --enable-simplexml --enable-sockets --enable-sysvmsg --enable-sysvsem --enable-sysvshm  --with-libxml-dir  --with-xsl --enable-zip --enable-mysqlnd-compression-support --with-pear --enable-intl