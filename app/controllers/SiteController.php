<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Cookie;
use yii\data\Pagination;
use app\models\NixShortUrls;
use yii\web\ErrorAction;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index'     => ['GET'],
                    'language'  => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => ['class' => ErrorAction::class],
        ];
    }

    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        $model_url = new NixShortUrls();
        $query = NixShortUrls::find()->where(['user_id' => 0]);

        if (!Yii::$app->user->isGuest) {
            $query = NixShortUrls::find()->where(['user_id' => Yii::$app->user->id]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => 25,
            'totalCount' => $query->count(),
        ]);

        $short_urls = $query->addOrderBy('id DESC')->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'short_urls' => $short_urls,
            'model_url' => $model_url,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Change language
     */
    public function actionLanguage(): void
    {
        $language = Yii::$app->request->post('language');

        Yii::$app->language = $language;
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'language',
            'value' => $language
        ]));
        Yii::$app->session->setFlash('success', Yii::t('burl', 'LANG_CHANGED'));
        $this->redirect(Yii::$app->request->referrer);
    }
}
