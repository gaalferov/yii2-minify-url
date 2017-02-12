<?php
/**
 * Application configuration for acceptance tests
 */
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../config/web.php'),
    file_exists(__DIR__ . '/../../../config/web-local.php') ? require(__DIR__ . '/../../../config/web-local.php') : [],
    require(__DIR__ . '/config.php'),
    [

    ]
);
