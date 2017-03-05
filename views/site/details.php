<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use scotthuangzl\googlechart\GoogleChart;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Details for short code - ' . $url->short_code;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode('Details for short code - ' . Url::base(true) . Url::to(['site/forward', 'code' => $url->short_code])) ?></h1>
<div class="row">
  <div class="col-md-12">
    <?php
    array_unshift($details['date'], ['Date', 'Clicks']);
    echo GoogleChart::widget(['visualization' => 'LineChart',
      'data' => $details['date'],
      'options' => [
        'vAxis' => [
          'gridlines' => [
            'color' => 'transparent'  //set grid line transparent
          ]],
      ]]);
    ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <?php
    array_unshift($details['user_platform'], ['Name', 'Clicks']);
    echo GoogleChart::widget(array('visualization' => 'PieChart',
      'data' => $details['user_platform'],
      'options' => [
        'title' => 'Platforms',
        'is3D' => true,
      ]));
    ?>
  </div>
  <div class="col-md-6">
    <?php
    array_unshift($details['user_agent'], ['Url', 'Clicks']);
    echo GoogleChart::widget(array('visualization' => 'PieChart',
      'data' => $details['user_agent'],
      'options' => [
        'title' => 'Browsers',
        'is3D' => true,
      ]
    ));
    ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <?php
    array_unshift($details['user_country'], ['Country', 'Popularity']);
    echo GoogleChart::widget(array('visualization' => 'GeoChart',
      'data' => $details['user_country'],
      'options' =>
        ['dataMode' => 'regions'],
    ));
    ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table cellspacing="0" class="table table-hover">
      <thead>
      <tr class="text-uppercase">
        <th>Refer url</th>
        <th class="text-center">Count</th>
      </tr>
      </thead>
      <tbody>
      <?php if (!empty($details['user_refer'])): ?>
        <?php foreach ($details['user_refer'] as $refer): ?>
          <tr>
            <td>
              <a href="<?= Html::encode("{$refer[0]}") ?>" target="_blank" rel="nofollow"><?= Html::encode("{$refer[0]}") ?></a>
            </td>
            <td>
              <div><?= $refer[1] ?></div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="2">
            You don't have private urls
          </td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>