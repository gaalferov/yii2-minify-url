<?php

$params = array_merge(
  require(__DIR__ . '/params.php'),
  file_exists(__DIR__ . '/params-local.php') ? require(__DIR__ . '/params-local.php') : []
);

$db = array_merge(
  require(__DIR__ . '/db.php'),
  file_exists(__DIR__ . '/db-local.php') ? require(__DIR__ . '/db-local.php') : []
);

$config = [
  'id' => 'basic',
  'basePath' => dirname(__DIR__),
  'bootstrap' => [
    'log',
    [
      'class' => 'app\components\LanguageSelector',
      'supportedLanguages' => ['en', 'ru'],
    ],
  ],
  'components' => [
    'request' => [
      // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      'cookieValidationKey' => '0i7oMoAf-jMDnoTcaQfyZy7KWjUY2kMF',
      'baseUrl' => ''
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    'mailer' => [
      'class' => 'yii\swiftmailer\Mailer',
      'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'host',
        'username' => 'username',
        'password' => 'password',
        'port' => '2525',
        'encryption' => 'tls',
        'streamOptions' => [
          'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
          ],
        ],
      ],
    ],
    'log' => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets' => [
        [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'db' => $db,
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
        '/signup' => '/user/user/signup',
        '/login' => '/user/user/login',
        '/logout' => '/user/user/logout',
        '/requestPasswordReset' => '/user/user/request-password-reset',
        '/resetPassword' => '/user/user/reset-password',
        '/profile' => '/user/user/profile',
        '/retryConfirmEmail' => '/user/user/retry-confirm-email',
        '/confirmEmail' => '/user/user/confirm-email',
        '/unbind/<id:[\w\-]+>' => '/user/auth/unbind',
        '/oauth/<authclient:[\w\-]+>' => '/user/auth/index',
        '/lang' => 'site/language',
        'details/<code:\w+>' => 'site/details',
        '<code:\w+>' => 'site/forward',
        '/' => 'site/index',

      ],
    ],
    'authManager' => [
      'class' => 'yii\rbac\DbManager',
    ],
    'user' => [
      'identityClass' => 'budyaga\users\models\User',
      'enableAutoLogin' => true,
      'loginUrl' => ['/login'],
    ],
    'authClientCollection' => [
      'class' => 'yii\authclient\Collection',
    ],
    'geoip' => [
      'class' => 'lysenkobv\GeoIP\GeoIP'
    ],
    'i18n' => [
      'translations' => [
        '*' => [
          'class' => 'yii\i18n\PhpMessageSource',
          'basePath' => '@app/messages',
          'sourceLanguage' => 'en',
          'forceTranslation' => true,
        ],
      ],
    ],
  ],
  'modules' => [
    'user' => [
      'class' => 'budyaga\users\Module',
      'customViews' => [
        'login' => '@app/views/user/login',
        'signup' => '@app/views/user/signup',
        'profile' => '@app/views/user/profile',
      ],
    ],
  ],
  'params' => $params,
];

if (YII_ENV_DEV) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
  ];

  $config['bootstrap'][] = 'gii';
  $config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
  ];
}

return $config;
