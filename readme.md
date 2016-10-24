FGL Store Operations Portal (Manager's Web) Installation Guide
===============================================================

Written by: Brent Garner (brent.garner@fglpsorts.com) and Megha Jyoti (megha.jyoti@fglsports.com)

**Last Updated: 23 August 2016**

##Starting Point

We started with the following:

* CentOS Linux release 7.2.1511 (Core)
* PHP 5.4.16 (this was default)
* Hostname ( _this will likely be fdms1ap01q.unix.ctcwest.ctc or 
fdms1ap01.unix.ctcwest.ctc_ )

Everything is run as a non-root user, with full sudo access.

#### Prerequisites

* Git user on FGL Stash (http://git.fglsports.com) with access to the portal and the storeapi projects
* Basic knowledge of git, Apache configuration and troubleshooting, and Linux opperating systems
* Wilcard DNS A record ( ie  *.fdms1ap01q.unix.ctcwest.ctc ) entry for virtual host CNAMEs 
* Changed /etc/sysconfig/selinux to `SELINUX=permissive` and `SELINUXTYPE=minimum` to allow read/write on log files within the app. If this is important, we will rely on the CoE to provide direction, but this is out of the scope of this document.
* All application files (Store API and Portal) need to be owned by `apache`
* For our installation, we've stopped and disabled the CentOS firewall
	- `systemctl disable firewalld`
	- `systemctl stop firewalld`


Install MySQL (MariaDB)
===============================================================

These are the intructions using MariaDB. We found that RHEL7 installed MySQL 5.7 instead, and if this is the case, it's no problem, the instructions will be basically the same.

This will install mariadb.x86_64 1:5.5.47-1.el7_2

```
sudo yum install mariadb-server mariadb
```

#### Start MariaDB, enable the service

```
sudo systemctl enable mariadb.service
sudo systemctl start mariadb.service
```

If MySQL 5.7 was installed, this is the command to enable and start:

```
sudo systemctl enable mysqld
sudo systemctl start mysqld
```


#### Run MySQL setup:

** If you installed MySQL 5.7, you will need to run this command to find the root password. It has been preset for you. You will have the option to reset the root password, but keep in mind, you will need to follow the FGL password standards. Don't loose the password. This command will only retrieve the temporary password, and not once it's been reset.

```
sudo cat /var/log/mysqld.log | grep temporary
```

You can now begin the installation.

```
sudo mysql_secure_installation
```
Follow the prompts, we set our root password to "root".

```
Enter current password for root (enter for none): <enter>
Set root password? [Y/n] y
Remove anonymous users? [Y/n] y
Disallow root login remotely? [Y/n] y
Remove test database and access to it? [Y/n] n
Reload privilege tables now? [Y/n] y
```

#### Create Databases

Log into MariaDB (same process for MySQL)

(assuming root for user and root for password)

````
mysql -uroot -proot  
````

At the MySQL(MariaDB) prompt:

````
CREATE DATABASE storeapi;
CREATE DATABASE fglportal;
exit; 
````

Upgrade to PHP 7 
===============================================================

PHP 7.0.5 may already be installed on the production server. You can check that by typing 

````
php -v
````
If you have `PHP 7.0.5 (cli) (built: Apr  2 2016 13:08:13) ( NTS )`, skip down the section called **PHP Packages**

If you have another version of PHP installed, follow these steps:

Using the Marks EPEL (prefered):

```
sudo subscription-manager repos --enable marks_epel-el7-x86_64_repo-epel-el7-x86_64
```

Using the Fedora EPEL (not recommended):

```
sudo rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
```

Using Webtatic (not recommended, but this is what we used on QA in order to get PHP 7.0.5):

```
sudo rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
```

We are going to just replace the default PHP that comes with CentOS. Depending on what EPEL is used, you may or may not have access to PHP 7.0.5

```
sudo yum install yum-plugin-replace
sudo yum replace php-common --replace-with=php70w-common
```

#### PHP packages:

The PDO and GD packages might have been installed with the Common package, but they are vital, so double-check that they are installed.

```
sudo yum install php70w-mbstring
sudo yum install php70w-mcrypt
sudo yum install php70w-mysql
sudo yum install php70w-pdo  
sudo yum install php70w-gd   
sudo yum install php70w-xml
```

#### Edit php.ini

```
sudo vi /etc/php.ini
```

Change the following parameters:

```
upload_max_filesize = 256M
```

```
post_max_size = 256M
```

#### Install Composer

````
wget https://getcomposer.org/installer
php installer
sudo mv composer.phar /usr/local/bin/composer
sudo chmod 777 /usr/local/bin/composer
````

Install/Configure Apache
===============================================================

Install Apache and add it as a service

```
sudo yum install httpd
sudo systemctl enable httpd.service
sudo systemctl start httpd.service
```

Create directories for portal and store api

```
sudo mkdir -p /var/www/portal/public
sudo mkdir -p /var/www/storeapi/public
```

Place a test index file in each. Put some text in each so you can identify the sites later. These files will be replaced later in the install process.

```
sudo touch /var/www/portal/public/index.html
sudo touch /var/www/storeapi/public/index.html
sudo vi /var/www/portal/public/index.html 
sudo vi /var/www/storeapi/public/index.html 
```

#### Setup the virtual hosting

```
sudo mkdir /etc/httpd/sites-available
sudo mkdir /etc/httpd/sites-enabled
```

#### Edit the httpd.conf file

```
sudo vi /etc/httpd/conf/httpd.conf
```
_Some of these changes might be done, some might need to be done, just check your httpd.conf file to make sure_

Line 42 and 43:

````
Listen *:80
````

Line 66 and 67:

````
User apache
Group apache
````

Line 95:

```
ServerName <your_hostname>:80
```

The `<Directory />` block:

````
<Directory />
    Options FollowSymLinks
    AllowOverride All
    Order allow,deny
    Allow from all
</Directory>
````

The `<Directory "/var/www">` block:

````
<Directory "/var/www">
    Options FollowSymLinks
    AllowOverride All
    Order allow,deny
    Allow from all
</Directory>
````

The `<Directory "/var/www/html">` block:

```
<Directory "/var/www/html">
    Options FollowSymLinks
    AllowOverride All
    Order allow,deny
    Allow from all
    Require all granted
</Directory>
```


Add to the end of the file:

```
Include sites-enabled/*.conf
```

Create the vhost file

```
sudo vi /etc/httpd/sites-available/portal.conf
```

Be sure to use whatever the hostname is for this server here

```
<VirtualHost *:80>
	ServerName portal.<your_hostname>
	DocumentRoot /var/www/portal/public
   Options FollowSymLinks
   ServerAlias portal.<your_hostname>
</VirtualHost>
```

Do the same for the Store API vhost

```
sudo vi /etc/httpd/sites-available/storeapi.conf
```

```
<VirtualHost *:80>
	ServerName storeapi.<your_hostname>
	DocumentRoot /var/www/storeapi/public
   Options FollowSymLinks
   ServerAlias storeapi.<your_hostname>
</VirtualHost>
```

Enable the new vhosts

```
sudo ln -s /etc/httpd/sites-available/portal.conf /etc/httpd/sites-enabled/portal.conf
sudo ln -s /etc/httpd/sites-available/storeapi.conf /etc/httpd/sites-enabled/storeapi.conf
```

Restart Apache

```
sudo systemctl restart httpd.service
```

Check Apache's status

```
systemctl status httpd.service
``` 

and follow any instructions to correct any misconfiguration that may be present.

Check the virtual hosts in a browser. You should see what you put in each index.html file.


Installing the App
===============================================================

You will need a user setup on Stash to access these projects

Store API
---------------------------------------------------------------

Remove the public directory at /var/www/storeapi

````
rm -rf /var/www/storeapi/public
````

Install from Stash. You will be prompted for your FGL git username/password.

````
cd /var/www/storeapi/
sudo git clone https://<git_username>@git.fglsports.com/scm/dgstore/storeapi.git . 
````

#### Create the .env file
This contains the username and password for our SQL connection. This file is never checked into git, so it needs to be created.

````
cd /var/www/storeapi
sudo touch .env
sudo vi .env
````

This is what the .env file should look like. Use the username and password setup for MySQL.

````
APP_ENV=local
APP_DEBUG=false
APP_KEY=iAP7dF7J6RuGKRGrjBLDSCqJymYQYQp2
DB_HOST=127.0.0.1
DB_DATABASE=storeapi
DB_USERNAME=root
DB_PASSWORD=root 
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
````

Change permissions/ownership on the storage directory and the vendor directory. This allows composer to install into these directories. This is temporary.

````
sudo chown -R apache:apache /var/www/storeapi
sudo chmod 777 /var/www/storeapi/storage
sudo chmod 777 /var/www/storeapi/vendor
````

Clear the cache

````
cd /var/www/storeapi
sudo php artisan cache:clear
````

Change permissions on the `vendor` folder to the user you are installing with, and run the composer commands. After that's done, change the ownership back to `apache`.

````
cd /var/www/storeapi
sudo chown -R <user>:<user> vendor/
composer install
composer dump-autoload
sudo chown -R apache:apache vendor/
````

Migrate the database

````
cd /var/www/storeapi
sudo php artisan migrate
````

Run the SQL script for the Store API. Again, we are assuming the user is "root" and the password is "root".

````
cd /var/www/storeapi/sql
mysql -uroot -proot storeapi < storeapi.sql
````

Restart Apache

````
sudo systemctl restart httpd.service
````

Once that is done, visit the Store API in a browser:
`http://storeapi.<your_hostname>/`

You should see a screen that says *"Lumen."*

Check one of the API routes by visiting `http://storeapi.<your_hostname>/banner/1` in a browser. This should return a JSON string. 


Installing the Portal
---------------------------------------------------------------

Remove the public directory at /var/www/portal

````
rm -rf /var/www/portal/public
````

Install from Stash. You will be prompted for your FGL git username/password.

````
cd /var/www/portal/
sudo git clone https://<git_username>@git.fglsports.com/scm/dgstore/portal.git . 
````

#### Create the .env file
This contains the username and password for our SQL connection. This file is never checked into git, so it needs to be created.

````
cd /var/www/portal
sudo touch .env
sudo vi .env
````

This is what the .env file should look like. Use the username and password setup for MySQL. Use the hostname that was setup for the Portal.

````
APP_ENV=local
APP_DEBUG=false
APP_KEY=iAP7dF7J6RuGKRGrjBLDSCqJymYQYQp2
STORE_API_DOMAIN=http://storeapi.<your_hostname>
DB_HOST=127.0.0.1
DB_DATABASE=fglportal
DB_USERNAME=root
DB_PASSWORD=root
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
````

Change permissions/ownership on the storage directory and the vendor directory. This allows composer to install into these directories. This is temporary.

````
sudo chown -R apache:apache /var/www/portal
sudo chmod 777 /var/www/portal/storage
sudo chmod 777 /var/www/portal/vendor
````

Clear the cache

````
cd /var/www/portal
sudo php artisan cache:clear
````

Change permissions on the `vendor` folder to the user you are installing with, and run the composer commands. After that's done, change the ownership back to `apache`.

````
cd /var/www/portal
sudo chown -R <user>:<user> vendor/
composer install
composer dump-autoload
sudo chown -R apache:apache vendor/
````

Create the env.js file

````
sudo touch /var/www/portal/public/js/env.js
sudo vi /var/www/portal/public/js/env.js
````

The env.js file should read:

````
const STORE_API_DOMAIN = "http://storeapi.<your_hostname>";
````

Migrate the database

````
cd /var/www/portal
sudo php artisan migrate
````

Run the SQL script for the Portal. Again, we are assuming the user is "root" and the password is "root".

````
cd /var/www/portal/sql
mysql -uroot -proot fglportal < install.sql
````

Change the permissions on the storage and vendor directories.

````
sudo chmod 775 /var/www/portal/storage
sudo chmod 775 /var/www/portal/vendor
````

Configure the data storage directories

```
mkdir -p /data/portal/files
mkdir -p /data/portal/images
mkdir -p /data/portal/video
mkdir -p /data/portal/video/thumbs
mkdir -p /data/portal/logs
```

Change their ownership and permissions

```
sudo chmod -R 775 /data/portal
sudo chown -R apache:apache /data/portal
```

Remove the existing logs directory 

````
sudo rm -rf /var/www/portal/storage/logs
````


Create the symbolic link for the logs and the files

```
sudo ln -s /data/portal/files /var/www/portal/public/files
sudo ln -s /data/portal/video /var/www/portal/public/video
sudo ln -s /data/portal/logs /var/www/portal/storage/logs
```

Restart Apache

````
sudo systemctl restart httpd.service
````

Once that is done, visit the Portal in a browser:
`http://portal.<your_hostname>/`

You should see a screen asking you to choose a banner and store. Check the drop down menus, they should be populated (the store dropdown populates after the banner is selected). If this is working, the integration between the Store API and the Portal is setup correctly.

Upon choosing a store, you should be taken to the Dashboad view of the Portal. 






