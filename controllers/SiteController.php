<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\NixShortUrls;
use app\models\NixUserInfo;

class SiteController extends Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionIndex()
    {
        $model_url = new NixShortUrls();

        //save url
        if ($model_url->load(Yii::$app->request->post())) {
            if ($model_url->validate()) {
                $model_url->checkUrl($model_url['long_url']);
                $model_url->setAttributes([
                    'short_code' => $model_url->genShortCode(),
                    'time_create' => date("Y-m-d H:i:s")
                ]);
                $model_url->save();
                return $this->refresh();
            }
        }
        //get all urls
        $query = NixShortUrls::find();
        $pagination = new Pagination([
            'defaultPageSize' => 25,
            'totalCount' => $query->count(),
        ]);

        $short_urls = $query->addOrderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'short_urls' => $short_urls,
            'model_url' => $model_url,
            'pagination' => $pagination,
        ]);

    }

    /**
     * @param $code
     * @return string
     * @throws \yii\web\HttpException
     * @throws \yii\web\NotAcceptableHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDetails($code)
    {
        $url = NixShortUrls::validateShortCode($code);

        return $this->render('details', [
            'url' => $url,
            'details' => NixUserInfo::sortGCArray(NixUserInfo::find()->where(['short_url_id' => $url['id']])->all())
        ]);
    }

    /**
     * @param $code
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     * @throws \yii\web\NotAcceptableHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionForward($code)
    {
        $model_info = new NixUserInfo();

        $url = NixShortUrls::validateShortCode($code);
        $url->updateCounters(['counter' => 1]);

        $user_info = parse_user_agent();
        $user_ip = Yii::$app->geoip->ip();

        $model_info->setAttributes([
            'short_url_id' => $url['id'],
            'user_platform' => $user_info['platform'],
            'user_agent' => $user_info['browser'] . ' ' . $user_info['version'],
            'user_refer' => Yii::$app->request->referrer,
            'user_ip' => Yii::$app->request->userIP,
            'user_country' => $user_ip->country,
            'user_city' => $user_ip->city,
            'date' => date("Y-m-d")
        ]);
        $model_info->save();

        return $this->redirect($url['long_url']);
    }

}
