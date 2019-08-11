<?php

use yii\db\Connection;

return [
    'class' => Connection::class,
    'charset' => 'utf8',
    'dsn' => 'mysql:host=' . getenv('MYSQL_HOST', 'localhost') . ';dbname=' . getenv('MYSQL_DATABASE', 'yii2Shortener'),
    'username' => getenv('MYSQL_USER', 'urlShortenerUser'),
    'password' => getenv('MYSQL_PASSWORD', 'yii2ShortenerPassword'),
    'tablePrefix' => getenv('MYSQL_TABLE_PREFIX', 'yii2'),
];
