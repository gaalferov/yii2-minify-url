<?php use yii\helpers\Html;?>
  <div class="row">
    <div class="col-md-6">
      <?= Html::beginForm('/lang'); ?>
      <?= Html::hiddenInput('language', 'ru'); ?>
      <?= Html::submitButton('<span class="lang-sm lang-lbl" lang="ru"></span>', ['class' => 'btn btn-link btn-md']); ?>
      <?= Html::endForm(); ?>
    </div>
    <div class="col-md-6">
      <?= Html::beginForm('/lang'); ?>
      <?= Html::hiddenInput('language', 'en'); ?>
      <?= Html::submitButton('<span class="lang-sm lang-lbl" lang="en"></span>', ['class' => 'btn btn-link btn-md']); ?>
      <?= Html::endForm(); ?>
    </div>
  </div>