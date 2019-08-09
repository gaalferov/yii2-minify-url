<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NixShortUrls */

$this->title = Yii::t('burl', 'UPDATE_SHORT_URL') . ': ' . $model->short_code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('burl', 'ALL_URLS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="nix-short-urls-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
