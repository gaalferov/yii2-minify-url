<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
  'brandLabel' => Yii::t('burl', 'NAVBAR_HOME'),
  'brandUrl' => Yii::$app->homeUrl,
  'options' => [
    'class' => 'navbar-inverse navbar-fixed-top',
  ],
]);
echo Nav::widget([
  'options' => ['class' => 'navbar-nav navbar-right'],
  'items' => [
    [
      'label' => Yii::t('burl', 'NAVBAR_LOGIN'),
      'url' => ['/login'],
      'visible' => Yii::$app->user->isGuest
    ],
    [
      'label' => Yii::t('burl', 'NAVBAR_SIGNUP'),
      'url' => ['/signup'],
      'visible' => Yii::$app->user->isGuest
    ],
    [
      'label' => Yii::t('burl', 'NAVBAR_PROFILE'),
      'url' => '/profile',
      'visible' => !Yii::$app->user->isGuest
    ],
    [
      'label' => Yii::t('burl', 'NAVBAR_USERS'),
      'url' => ['/user/admin'],
      'visible' => Yii::$app->user->can('userManage')
    ],
    [
      'label' => Yii::t('burl', 'ALL_URLS'),
      'url' => ['/url/index'],
      'visible' => Yii::$app->user->can('urlManage')
    ],
    [
      'label' => Yii::t('burl', 'NAVBAR_RBAC'),
      'url' => ['/user/rbac'],
      'visible' => Yii::$app->user->can('rbacManage')
    ],
    [
      'label' => Yii::t('burl', 'NAVBAR_LOGOUT'),
      'url' => '/logout',
      'visible' => !Yii::$app->user->isGuest
    ],
  ],
]);
NavBar::end();
