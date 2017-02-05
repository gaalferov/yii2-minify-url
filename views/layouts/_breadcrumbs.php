<?php
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Alert;

echo  Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);

foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo Alert::widget(['options' => ['class' => 'alert-'.$key], 'body' => $message]);
}