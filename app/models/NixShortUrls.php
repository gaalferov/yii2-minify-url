<?php

namespace app\models;

use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\NotAcceptableHttpException;
use yii\helpers\BaseArrayHelper;
use linslin\yii2\curl;

/**
 * This is the model class for table "{{%short_urls}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $long_url
 * @property string $short_code
 * @property string $time_create
 * @property string $time_end
 * @property integer $counter
 *
 * @property UserInfo[] $userInfos
 */
class NixShortUrls extends \yii\db\ActiveRecord
{

  /**
   * Cache duration
   */
  const CACHE_DURATION = 60;
  /**
   * Allowed characters for short urls
   */
  const ALLOWED_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return '{{%short_urls}}';
  }

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['long_url'], 'required'],
      [['long_url'], 'url'],
      [['time_create', 'time_end'], 'safe'],
      [['counter', 'user_id'], 'integer'],
      [['short_code'], 'string', 'max' => 6],
      [['short_code'], 'unique']
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('burl', 'ID'),
      'user_id' => Yii::t('burl', 'USER_ID'),
      'long_url' => Yii::t('burl', 'LONG_URL'),
      'short_code' => Yii::t('burl', 'SHORT_CODE'),
      'time_create' => Yii::t('burl', 'CREATED_TIME'),
      'time_end' => Yii::t('burl', 'TIME_END'),
      'counter' => Yii::t('burl', 'COUNTER'),
    ];
  }

  /**
   * @return string
   */
  public function genShortCode()
  {
    do {
      $shortCode = substr(str_shuffle(self::ALLOWED_CHARS), 0, 6);
    } while (NixShortUrls::find()->where(['short_code' => $shortCode])->one());

    return $shortCode;
  }

  /**
   * @param $code
   * @return array|null|\yii\db\ActiveRecord
   * @throws HttpException
   * @throws NotAcceptableHttpException
   * @throws NotFoundHttpException
   */
  public static function validateShortCode($code)
  {
    if (!preg_match('|^[0-9a-zA-Z]{6,6}$|', $code)) {
      throw new HttpException(400, Yii::t('burl', 'ENTER_VALID_SHORT_CODE'));
    }

    $url = NixShortUrls::find()->where(['short_code' => $code])->one();

    if ($url === null) {
      throw new NotFoundHttpException(Yii::t('burl', 'SHORT_CODE_NOT_FOUND') . $code);
    } else if (!is_null($url['time_end']) && date("Y-m-d H:i:s") > $url['time_end']) {
      throw new NotAcceptableHttpException(Yii::t('burl', 'SHORT_CODE_END_TIME') . $url['time_end']);
    }

    return $url;
  }

  /**
   * @param $url
   * @throws HttpException
   */
  public function checkUrl($url)
  {
    $curl = new curl\Curl();

    $curl->setOption(CURLOPT_SSL_VERIFYHOST, false);
    $curl->setOption(CURLOPT_SSL_VERIFYPEER, false);
    $curl->setOption(CURLOPT_FOLLOWLOCATION, true);
    $curl->setOption(CURLOPT_RETURNTRANSFER, true);
    $curl->setOption(CURLOPT_AUTOREFERER, true);
    $curl->setOption(CURLOPT_CONNECTTIMEOUT, 60);
    $curl->setOption(CURLOPT_TIMEOUT, 30);
    $curl->setOption(CURLOPT_MAXREDIRS, 10);
    $curl->setOption(CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36');

    $curl->get($url);

    if ($curl->responseCode != 200) {
      throw new HttpException(400, Yii::t('burl', 'SHORT_CODE_ERROR_URL') . $curl->responseCode);
    }
  }

  /**
   * @return mixed
   */
  public function getTotalSumCounter()
  {
    return NixShortUrls::getDb()->cache(function () {
      return NixShortUrls::find()->from(self::tableName())->sum('counter');
    }, self::CACHE_DURATION);
  }

  /**
   * @return int|string
   */
  public function getTotalUrls()
  {
    return NixShortUrls::getDb()->cache(function () {
      return NixShortUrls::find()->from(self::tableName())->count();
    }, self::CACHE_DURATION);
  }

  /**
   * Build array to view in Google Charts
   * @param $users_info
   * @return array
   */
  public static function sortGCArray($users_info)
  {
    $users_info = BaseArrayHelper::toArray($users_info);

    return [
      'user_agent' => static::getUsersInfo($users_info, 'user_agent'),
      'user_refer' => static::getUsersInfo($users_info, 'user_refer'),
      'user_platform' => static::getUsersInfo($users_info, 'user_platform'),
      'user_country' => static::getUsersInfo($users_info, 'user_country'),
      'user_city' => static::getUsersInfo($users_info, 'user_city'),
      'date' => static::getUsersInfo($users_info, 'date')
    ];
  }

  /**
   * @param $users_info
   * @param $name
   * @return array
   */
  public static function getUsersInfo($users_info, $name)
  {
    $array = [];

    //get needed column
    $users_info = array_filter(BaseArrayHelper::getColumn($users_info, $name, false));
    $users_info = array_count_values($users_info);

    foreach ($users_info as $key => $value)
      $array[] = [$key, $value];

    return $array;
  }
}
