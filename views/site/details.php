<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use scotthuangzl\googlechart\GoogleChart;
use yii\helpers\Url;

$this->title = 'Details for short code - ' . $url->short_code;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode('Details for short code - ' . Url::base(true) . Url::to(['site/forward', 'code' => $url->short_code])) ?></h1>
<div class="row">
    <div class="col-md-12">
        <?php
        array_unshift($details['date'], ['Date', 'Clicks']);
        echo GoogleChart::widget(array('visualization' => 'LineChart',
            'data' => $details['date'],
            'options' => array(
                'vAxis' => array(
                    'gridlines' => array(
                        'color' => 'transparent'  //set grid line transparent
                    )),
            )));
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php
        array_unshift($details['user_refer'], ['Url', 'Clicks']);
        echo GoogleChart::widget(array('visualization' => 'PieChart',
            'data' => $details['user_refer'],
            'options' => array('title' => 'Referrers')));
        ?>
    </div>
    <div class="col-md-6">
        <?php
        array_unshift($details['user_agent'], ['Url', 'Clicks']);
        echo GoogleChart::widget(array('visualization' => 'PieChart',
            'data' => $details['user_agent'],
            'options' => array('title' => 'Browsers')));
        ?>
    </div>
</div>