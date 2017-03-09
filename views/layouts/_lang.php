<?php use yii\helpers\Html;?>
<?= Html::beginForm('/lang', 'post',  ['class' => 'pull-right']); ?>
<?= Html::hiddenInput('language', 'ru'); ?>
<?= Html::submitButton('<span class="lang-sm lang-lbl" lang="ru"></span>', ['class' => 'btn btn-link btn-md']); ?>
<?= Html::endForm(); ?>
<?= Html::beginForm('/lang', 'post',  ['class' => 'pull-right']); ?>
<?= Html::hiddenInput('language', 'en'); ?>
<?= Html::submitButton('<span class="lang-sm lang-lbl" lang="en"></span>', ['class' => 'btn btn-link btn-md']); ?>
<?= Html::endForm(); ?>
