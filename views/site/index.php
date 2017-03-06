<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\NixShortUrls */
/* @var $form ActiveForm */
$this->title = Yii::t('burl', 'BURL_TITLE');
?>
<div class="site-index">

    <div class="row">
        <div class="col-xs-12 col-lg-7 jumbotron">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model_url, 'long_url')->input('url', ['placeholder' => 'http://yousite.com/'])->label(Yii::t('burl', 'ADD_URL')) ?>
            <?= Html::label(Yii::t('burl', 'DISABLE_SHORT_URL'), 'NixShortUrls[time_end]') ?>
            <?= Html::radioList('NixShortUrls[time_end]', '', ['' => Yii::t('burl', 'TIME_NEVER_END'), date('Y-m-d H:i:s', strtotime('+1 week')) => Yii::t('burl', 'TIME_ONE_WEEK'), date('Y-m-d H:i:s', strtotime('+1 month')) => Yii::t('burl', 'TIME_ONE_MONTH')], ['tag' => 'div id="NixShortUrls[time_end]"']) ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('burl', 'SHORTEN_URL'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="hidden-xs col-lg-5 jumbotron">
                <p><?= Yii::t('burl', 'SITE_STATISTICS') ?></p>
                <div class="row text-lowercase">
                    <div class="col-lg-6 text-center">
                        <p class="text-center"><?=777 + (int)$model_url->totalUrls?></p>
                        <p class="text-center"><small><?= Yii::t('burl', 'TOTAL_SU') ?></small></p>
                    </div>
                    <div class="col-lg-6 text-center">
                        <p class="text-center"><?=3584 + (int)$model_url->totalSumCounter?></p>
                        <p class="text-center"><small><?= Yii::t('burl', 'TOTAL_UV') ?></small></p>
                    </div>
                </div>
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table cellspacing="0" class="table table-hover">
                    <caption><?= (!Yii::$app->user->isGuest) ? Yii::t('burl', 'YOUR_URLS') : Yii::t('burl', 'LAST_PUBLIC_URLS');?>:</caption>
                    <thead>
                    <tr class="text-uppercase">
                        <th><?= Yii::t('burl', 'ORIGINAL_URL') ?></th>
                        <th><?= Yii::t('burl', 'CREATED') ?></th>
                        <th class="text-center"><?= Yii::t('burl', 'CLICKS') ?></th>
                        <th class="text-center"><?= Yii::t('burl', 'SHORT_URL') ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($short_urls)): ?>
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
                                    <a href="<?=  Url::to(['site/forward', 'code' => $url->short_code]) ?>" target="_blank"><?=  Url::to(['site/forward', 'code' => $url->short_code], true) ?></a>
                                </td>
                                <td class="text-right">
                                    <a href="<?=  Url::to(['site/details', 'code' => $url->short_code]) ?>"><?= Yii::t('burl', 'ANALYTICS') ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <?= Yii::t('burl', 'YOU_DONT_HAVE_PRIVATE_URLS') ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div><!-- index -->

<?= LinkPager::widget(['pagination' => $pagination]) ?>
