Yii 2 Minify-URL Project (Shortener)
============================

This is my first project on yii2 framework.
You can see [demo](http://s.gaalferov.com/)

For example:
* Long url: http://longurlsitename.com/blog-2016/very-long-article-2016.html
* Short url: http://yousite.com/aBcDeF

What you can do
----
* Input your long url and get short
* View statistics (Google Charts)


### Install via Composer
----
If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install the application using the following command:

~~~
git clone https://github.com/gaalferov/yii2-minify-url.git
composer global require "fxp/composer-asset-plugin:~1.1.1"
cd yii2-minify-url
composer install
~~~

GETTING STARTED
---------------

After you install the application, you have to conduct the following steps to initialize the installed application. You only need to do these once for all.

* Create a new database
* Edit the file `config/db.php` with real data, for example:
```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2',
    'username' => 'mysql',
    'password' => 'mysql',
    'charset' => 'utf8',
    'tablePrefix' => 'nix_',
];
```
* Apply migrations with console command `yii migrate` or `php yii migrate`. This will create tables needed for the application to work.


Now you can then access the application through the following URL:
~~~
http://localhost/yii2-minify-url/web/
~~~

Configuring Web Servers <span id="configuring-web-servers"></span>
-----------------------

> Info: You may skip this subsection for now if you are just test driving Yii with no intention
  of deploying it to a production server.

The application installed according to the above instructions should work out of box with either
an [Apache HTTP server](http://httpd.apache.org/) or an [Nginx HTTP server](http://nginx.org/), on
Windows, Mac OS X, or Linux running PHP 5.4 or higher. Yii 2.0 is also compatible with facebook's
[HHVM](http://hhvm.com/). However, there are some edge cases where HHVM behaves different than native
PHP, so you have to take some extra care when using HHVM.

On a production server, you may want to configure your Web server so that the application can be accessed
via the URL `http://www.example.com/index.php` instead of `http://www.example.com/basic/web/index.php`. Such configuration
requires pointing the document root of your Web server to the `basic/web` folder. You may also
want to hide `index.php` from the URL, as described in the [Routing and URL Creation](runtime-routing.md) section.
In this subsection, you'll learn how to configure your Apache or Nginx server to achieve these goals.

> Info: By setting `basic/web` as the document root, you also prevent end users from accessing
your private application code and sensitive data files that are stored in the sibling directories
of `basic/web`. Denying access to those other folders is a security improvement.

> Info: If your application will run in a shared hosting environment where you do not have permission
to modify its Web server configuration, you may still adjust the structure of your application for better security. Please refer to
the [Shared Hosting Environment](tutorial-shared-hosting.md) section for more details.


### Recommended Apache Configuration <span id="recommended-apache-configuration"></span>

Use the following configuration in Apache's `httpd.conf` file or within a virtual host configuration. Note that you
should replace `path/to/basic/web` with the actual path for `basic/web`.

```apache
# Set document root to be "basic/web"
DocumentRoot "path/to/basic/web"

<Directory "path/to/basic/web">
    # use mod_rewrite for pretty URL support
    RewriteEngine on
    # If a directory or a file exists, use the request directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # Otherwise forward the request to index.php
    RewriteRule . index.php

    # ...other settings...
</Directory>
```


### Recommended Nginx Configuration <span id="recommended-nginx-configuration"></span>

To use [Nginx](http://wiki.nginx.org/), you should install PHP as an [FPM SAPI](http://php.net/install.fpm).
You may use the following Nginx configuration, replacing `path/to/basic/web` with the actual path for 
`basic/web` and `mysite.local` with the actual hostname to serve.

```nginx
server {
    charset utf-8;
    client_max_body_size 128M;

    listen 80; ## listen for ipv4
    #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

    server_name mysite.local;
    root        /path/to/basic/web;
    index       index.php;

    access_log  /path/to/basic/log/access.log;
    error_log   /path/to/basic/log/error.log;

    location / {
        # Redirect everything that isn't a real file to index.php
        try_files $uri $uri/ /index.php?$args;
    }

    # uncomment to avoid processing of calls to non-existing static files by Yii
    #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
    #    try_files $uri =404;
    #}
    #error_page 404 /404.html;

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
        fastcgi_pass   127.0.0.1:9000;
        #fastcgi_pass unix:/var/run/php5-fpm.sock;
        try_files $uri =404;
    }

    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
```

When using this configuration, you should also set `cgi.fix_pathinfo=0` in the `php.ini` file
in order to avoid many unnecessary system `stat()` calls.

Also note that when running an HTTPS server, you need to add `fastcgi_param HTTPS on;` so that Yii
can properly detect if a connection is secure.