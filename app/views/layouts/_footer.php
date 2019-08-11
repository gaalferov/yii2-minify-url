<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-6">&copy; GAAlferov <?= date('Y') ?></div>
            <div class="col-md-4 col-sm-4 col-xs-6 pull-right"><?= $this->render('_lang'); ?></div>
        </div>
    </div>
</footer>
<?=\Yii::$app->params['footerJS']?>