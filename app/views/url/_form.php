<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NixShortUrls */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nix-short-urls-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'long_url')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'short_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'time_create')->textInput() ?>
    <?= $form->field($model, 'time_end')->textInput() ?>
    <?= $form->field($model, 'counter')->textInput() ?>
    <?= $form->field($model, 'note')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
