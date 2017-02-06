<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => 'Home',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        [
            'label' => 'Login',
            'url' => ['/login'],
            'visible' => Yii::$app->user->isGuest
        ],
        [
            'label' => 'Signup',
            'url' => ['/signup'],
            'visible' => Yii::$app->user->isGuest
        ],
        [
            'label' => 'Profile',
            'url' => '/profile',
            'visible' => !Yii::$app->user->isGuest
        ],
        [
            'label' => 'Users',
            'url' => ['/user/admin'],
            'visible' => Yii::$app->user->can('userManage')
        ],
        [
            'label' => 'RBAC',
            'url' => ['/user/rbac'],
            'visible' => Yii::$app->user->can('rbacManage')
        ],
        [
            'label' => 'Logout',
            'url' => '/logout',
            'visible' => !Yii::$app->user->isGuest
        ],
    ],
]);
NavBar::end();
