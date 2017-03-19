<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\NixShortUrls;
use app\models\NixUserInfo;

class DetailsController extends Controller
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
    ];
  }

  /**
   * @return array
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => true,
            'actions' => ['index'],
            'matchCallback' => function ($rule, $action) {
              return $this->_checkAccess(Yii::$app->request->get('code'));
            }
            //'roles' => ['detailsView'],
          ],
        ],
      ],
    ];
  }

  /**
   * @param $code
   * @return string
   * @throws \yii\web\HttpException
   * @throws \yii\web\NotAcceptableHttpException
   * @throws \yii\web\NotFoundHttpException
   */
  public function actionIndex($code)
  {
    $url = NixShortUrls::validateShortCode($code);

    return $this->render('index', [
      'url' => $url,
      'details' => NixShortUrls::sortGCArray(NixUserInfo::find()->where(['short_url_id' => $url['id']])->all())
    ]);
  }

  /**
   * @param $code
   * @return bool
   * @throws \yii\web\HttpException
   * @throws \yii\web\NotAcceptableHttpException
   * @throws \yii\web\NotFoundHttpException
   */
  protected function _checkAccess($code)
  {
    $codeInfo = NixShortUrls::validateShortCode($code);

    if ($codeInfo->user_id) {
      return Yii::$app->user->can('detailsView', ['code' => $codeInfo]);
    }

    return true;
  }

}
