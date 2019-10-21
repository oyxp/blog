

#

       wget https://dev.mysql.com/get/mysql80-community-release-el7-2.noarch.rpm
       rpm -ivh mysql80-community-release-el7-2.noarch.rpm  --force --nodeps
       yum install mysql-community-server
       
       alter user 'root'@'localhost' identified by '12345678';
       set password for 'root'@'localhost'=password('12345678');
       grant all privileges on *.* to 'root'@'%' identified by '12345678';