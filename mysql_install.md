### mysql 5.7 install for el7 (php7.1.9 / apache 2.4)

##### marinaDB の削除 (/var/libは残りかすがある場合)
```
# yum remove mariadb-*
# rm -rf /var/lib/mysql/
```

##### mysql install
https://dev.mysql.com/downloads/repo/yum/
```
# rpm -Uvh http://dev.mysql.com/get/mysql57-community-release-el7-7.noarch.rpm
# yum info mysql-community-server
# yum -y install mysql-community-server
# mysqld --version
mysqld  Ver 5.7.19 for Linux on x86_64 (MySQL Community Server (GPL)) 
```

##### setup
```
cat /var/log/mysqld.log | grep root
# mysql_secure_installation
```

##### phpMyAdmin install
```
# yum install --enablerepo=remi-php71 phpMyAdmin
# vi /etc/httpd/conf.d/phpMyAdmin.conf
// <Directory /usr/share/phpMyAdmin/>　この辺の調整
```
