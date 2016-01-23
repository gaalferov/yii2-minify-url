<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\NixShortUrls */
/* @var $form ActiveForm */
$this->title = 'Minifi URL';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model_url, 'long_url')->input('url', ['placeholder' => 'http://yousite.com/'])->label('Paste your long URL here:') ?>
        <?= Html::label('Disable short url?', 'NixShortUrls[time_end]') ?>
        <?= Html::radioList('NixShortUrls[time_end]', '', ['' => 'Never', date('Y-m-d', strtotime('+1 week')) => 'One week', date('Y-m-d', strtotime('+1 month')) => 'One month'], ['tag' => 'div id="NixShortUrls[time_end]"']) ?>
        <div class="form-group">
            <?= Html::submitButton('Shorten URL', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="body-content">
        <div class="row">
            <?php if (!empty($short_urls)): ?>
            <div class="col-lg-12 table-responsive">
                <table cellspacing="0" class="table">
                    <thead>
                    <tr>
                        <th>LONG URL</th>
                        <th>CREATED</th>
                        <th>SHORT URL</th>
                        <th></th>
                        <th>CLICKS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($short_urls as $url): ?>
                        <tr>
                            <td>
                                <a href="<?= Html::encode("{$url->long_url}") ?>" target="_blank" rel="nofollow"><?= Html::encode("{$url->long_url}") ?></a>
                            </td>
                            <td>
                                <div><?= $url->time_create ?></div>
                            </td>
                            <td>
                                <a href="<?=  Url::to(['site/forward', 'code' => $url->short_code]) ?>" target="_blank"><?= $url->short_code ?></a>
                            </td>
                            <td>
                                <a href="<?=  Url::to(['site/details', 'code' => $url->short_code]) ?>">Details</a>
                            </td>
                            <td>
                                <div><?= $url->counter ?></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div><!-- index -->

<?= LinkPager::widget(['pagination' => $pagination]) ?>
