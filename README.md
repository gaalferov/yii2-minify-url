Yii 2 Minify-URL Project (Shortener)
============================

This is my first project on yii2 framework.
You can see [demo](http://burl.pro/)

For example:
* Long url: http://longurlsitename.com/blog-2016/very-long-article-2016.html
* Short url: http://yousite.com/aBcDeF

What you can do
----
* Input your long url and get short
* View statistics (Google Charts)

![Main page](https://camo.githubusercontent.com/e4a645ad484fdc78ee2bb753ead0d98ea2c0b6dc/687474703a2f2f732e6761616c6665726f762e636f6d2f7765622f696d6167652f6d61696e2e6a7067)

### Install via Composer
----
If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install the application using the following command:

~~~
git clone https://github.com/gaalferov/yii2-minify-url.git .
composer global update fxp/composer-asset-plugin --no-plugins
composer install
~~~

GETTING STARTED
---------------

After you install the application, you have to conduct the following steps to initialize the installed application. You only need to do these once for all.

* Create a new database
* Add new files with content
```
config/db-local.php
config/params-local.php
config/web-local.php
```
```php
<?php
return [];
```
* Edit the file `config/db-local.php` with real data, for example:
```php
<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2',
    'username' => 'yourUsername',
    'password' => 'yourPassword',
    'charset' => 'utf8',
    'tablePrefix' => 'nix_',
];
```
* Add to file `config/web-local.php` your oauth data, for example:
```php
<?php
return  [
  'components' => [
    'authClientCollection' => [
      'clients' => [
        'vkontakte' => [
          'class' => 'budyaga\users\components\oauth\VKontakte',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
          'scope' => 'email'
        ],
        'google' => [
          'class' => 'budyaga\users\components\oauth\Google',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
        ],
        'facebook' => [
          'class' => 'budyaga\users\components\oauth\Facebook',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
        ],
        'github' => [
          'class' => 'budyaga\users\components\oauth\GitHub',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
          'scope' => 'user:email, user'
        ],
        'linkedin' => [
          'class' => 'budyaga\users\components\oauth\LinkedIn',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
        ],
        'live' => [
          'class' => 'budyaga\users\components\oauth\Live',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
        ],
        'yandex' => [
          'class' => 'budyaga\users\components\oauth\Yandex',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
        ],
        'twitter' => [
          'class' => 'budyaga\users\components\oauth\Twitter',
          'consumerKey' => 'XXX',
          'consumerSecret' => 'XXX',
        ],
      ],
    ],
  ],
];
```
* Apply migrations with console command:
```php
php yii migrate
php yii migrate/up --migrationPath=@vendor/budyaga/yii2-users/migrations
```

Now you can then access the application through the following URL:
~~~
http://localhost/
~~~

TESTS
---------------
* Init codeception files:
```
php vendor/bin/codecept bootstrap
```
* Change url to your project in file /tests/acceptance.suite.yml
```
config:
        PhpBrowser:
            url: 'http://you_url.loc'
```
* Run tests:
```
php vendor/bin/codecept run
```
