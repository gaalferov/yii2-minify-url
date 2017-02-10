<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\NixShortUrls */
/* @var $form ActiveForm */
$this->title = 'Business URLs';
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-7 jumbotron">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model_url, 'long_url')->input('url', ['placeholder' => 'http://yousite.com/'])->label('Paste your original URL here:') ?>
            <?= Html::label('Disable short url?', 'NixShortUrls[time_end]') ?>
            <?= Html::radioList('NixShortUrls[time_end]', '', ['' => 'Never', date('Y-m-d H:i:s', strtotime('+1 week')) => 'One week', date('Y-m-d H:i:s', strtotime('+1 month')) => 'One month'], ['tag' => 'div id="NixShortUrls[time_end]"']) ?>
            <div class="form-group">
                <?= Html::submitButton('Shorten URL', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-5 jumbotron">
                <p>Site statistics:</p>
                <div class="row text-lowercase">
                    <div class="col-lg-6 text-center">
                        <p class="text-center"><?=777 + (int)$model_url->totalUrls?></p>
                        <p class="text-center"><small>Total Short Urls</small></p>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5 text-center">
                        <p class="text-center"><?=3584 + (int)$model_url->totalSumCounter?></p>
                        <p class="text-center"><small>Total Url Visits</small></p>
                    </div>
                </div>
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <?php if (!empty($short_urls)): ?>
            <div class="col-lg-12 table-responsive">
                <table cellspacing="0" class="table table-hover">
                    <caption>Public URLS:</caption>
                    <thead>
                    <tr class="text-uppercase">
                        <th>Original url</th>
                        <th>Created</th>
                        <th class="text-center">Clicks</th>
                        <th class="text-center">Short URL</th>
                        <th></th>
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
                            <td class="text-center">
                                <div><?= $url->counter ?></div>
                            </td>
                            <td class="text-center">
                                <a href="<?=  Url::to(['site/forward', 'code' => $url->short_code]) ?>" target="_blank"><?= $url->short_code ?></a>
                            </td>
                            <td class="text-right">
                                <a href="<?=  Url::to(['site/details', 'code' => $url->short_code]) ?>">Analytics</a>
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
