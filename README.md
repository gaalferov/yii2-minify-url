Yii 2 Minify-URL Project (Url Shortener)
========================================

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/40ba1520435842279111a89b137aace0)](https://www.codacy.com/app/gaalferov/yii2-minify-url?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=gaalferov/yii2-minify-url&amp;utm_campaign=Badge_Grade)

URL Shortener on Yii2 Framework.
Live demo - [https://burl.pro](https://burl.pro/)

Features
----
* Public urls (without registration) with public analytics information
* Private urls (after registration) with hidden analytics information
* A lot of popular social networks for registration (VK, FB, Google+, etc)
* Collect all client information geo position (country), browser, platform, referral

## Docker setup
* Install [docker & docker-compose](https://www.docker.com/)
* Copy and customize your docker arguments with command: `cp .env-dist .env`
* Create and set your own [GitHub API Token](https://github.com/settings/tokens) to the field `GITHUB_API_TOKEN` for fixing problem with rate limits
* Run docker build command: `docker-compose up --build -d`
* Run Yii2 migrate command: `docker exec yii2-minify-url_app_1 php yii migrate --interactive=0`


* Url Shortener will be available at [http://localhost](http://localhost)
* PHPMyAdmin available at [http://localhost:8080](http://localhost:8080)

### Default credentials
~~~
Admin area:
User: admin@burl.pro
Password: adminpassword

MySQL (.env):
User: urlshorteneruser
Password: yii2shortenerpassword
~~~

### Oauth configurations
* Add to file `app/config/web-local.php` your oauth data, for example:
```php
<?php
return  [
  'components' => [
    'authClientCollection' => [
      'clients' => [
        'google' => [
          'class' => 'app\components\oauth\Google',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
        ],
        'facebook' => [
          'class' => 'budyaga\users\components\oauth\Facebook',
          'clientId' => 'XXX',
          'clientSecret' => 'XXX',
        ],
        // twitter, facebook, github, linkedin, live, yandex, vkontakte
      ],
    ],
  ],
];
```
#### Example:
* Long url: https://gaalferov.com/about-me.html
* Short url: https://burl.pro/QTkNRW
![Example](https://burl.pro/images/example.gif)
