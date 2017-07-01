<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('burl', 'ALL_URLS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nix-short-urls-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'label' => 'user_id',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return $dataProvider->user_id ? Html::a($dataProvider->user_id, 'user/admin/view?id=' . $dataProvider->user_id) : '';
                },
            ],
            [
                'label' => 'long_url',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return mb_strimwidth(Html::encode("{$dataProvider->long_url}"), 0, 50, "...");
                },
            ],
            [
                'label' => 'short_code',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return Html::a($dataProvider->short_code, 'details/' . $dataProvider->short_code);
                },
            ],
            'time_create',
            'time_end',
            'counter',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
