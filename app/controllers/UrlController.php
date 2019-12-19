<?php

namespace app\controllers;

use Yii;
use app\models\NixShortUrls;
use app\models\NixShortUrlsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use app\models\NixUserInfo;
use yii\web\Response;
use yii\captcha\CaptchaAction;
use yii\web\ErrorAction;

/**
 * UrlController implements the CRUD actions for NixShortUrls model.
 */
class UrlController extends Controller
{
    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'add'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['add'],
                        'verbs' => ['POST'],
                        'matchCallback' => function () {
                            return !Yii::$app->user->isGuest ? Yii::$app->user->can('urlCreate') : true;
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'verbs' => ['POST'],
                        'roles' => ['urlManage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'update'],
                        'roles' => ['urlManage'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all NixShortUrls models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new NixShortUrlsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    /**
     * Updates an existing NixShortUrls model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return string
     */
    public function actionUpdate($id): string
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render(
            'update',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Deletes an existing NixShortUrls model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return Response
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the NixShortUrls model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return NixShortUrls the loaded model
     * @throws NotFoundHttpException
     */
    protected function findModel($id): NixShortUrls
    {
        if (($model = NixShortUrls::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Add Action
     */
    public function actionAdd(): Response
    {
        $model_url = new NixShortUrls();

        if (Yii::$app->request->post()) {
            if ($model_url->load(Yii::$app->request->post()) && $model_url->validate()) {
                if (!Yii::$app->user->isGuest) {
                    $model_url->setAttributes(
                        [
                            'user_id' => Yii::$app->user->id
                        ]
                    );
                }
                $model_url->checkUrl($model_url['long_url']);
                $model_url->setAttributes(
                    [
                        'short_code' => $model_url->genShortCode(),
                        'time_create' => date("Y-m-d H:i:s")
                    ]
                );
                $model_url->save();
                Yii::$app->session->setFlash('success', Yii::t('burl', 'CREATED_NEW_SHORT_URL'));
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $code
     *
     * @return Response
     */
    public function actionForward($code): Response
    {
        $model_info = new NixUserInfo();

        $url = NixShortUrls::validateShortCode($code);
        $url->updateCounters(['counter' => 1]);

        $user_info = parse_user_agent();
        $user_ip = Yii::$app->geoip->ip();

        $model_info->setAttributes(
            [
                'short_url_id' => $url['id'],
                'user_platform' => $user_info['platform'],
                'user_agent' => $user_info['browser'],
                'user_refer' => Yii::$app->request->referrer,
                'user_ip' => Yii::$app->request->userIP,
                'user_country' => $user_ip->country,
                'user_city' => $user_ip->city,
                'date' => date('Y-m-d')
            ]
        );
        $model_info->save();

        return $this->redirect($url['long_url']);
    }
}
