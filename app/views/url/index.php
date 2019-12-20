<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\NixShortUrlsSearch */

$this->title = Yii::t('burl', 'ALL_URLS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nix-short-urls-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'label' => Yii::t('burl', 'USER_ID'),
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return $dataProvider->user_id ? Html::a($dataProvider->user_id, 'user/admin/view?id=' . $dataProvider->user_id) : '';
                },
            ],
            [
                'label' => Yii::t('burl', 'LONG_URL'),
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return mb_strimwidth(Html::encode("{$dataProvider->long_url}"), 0, 50, "...");
                },
            ],
            [
                'label' => Yii::t('burl', 'SHORT_CODE'),
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    return Html::a($dataProvider->short_code, 'details/' . $dataProvider->short_code);
                },
            ],
            'time_create',
            'time_end',
            'counter',
            'note',
            ['class' => ActionColumn::class, 'template' => '{update} {delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
