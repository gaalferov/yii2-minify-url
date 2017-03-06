<?php

namespace app\models;

use Yii;
use yii\helpers\BaseArrayHelper;

/**
 * This is the model class for table "{{%short_urls_info}}".
 *
 * @property integer $id
 * @property integer $short_url_id
 * @property string $user_agent
 * @property string $user_refer
 * @property string $user_ip
 * @property string $date
 *
 * @property ShortUrls $shortUrl
 */
class NixUserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%short_urls_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short_url_id', 'user_agent', 'user_ip', 'date'], 'required'],
            [['short_url_id'], 'integer'],
            [['date'], 'safe'],
            [['user_platform','user_agent', 'user_refer', 'user_ip', 'user_country', 'user_city'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('burl', 'ID'),
            'short_url_id' => Yii::t('burl', 'SHORT_URL_ID'),
            'user_platform' => Yii::t('burl', 'USER_PLATFORM'),
            'user_agent' => Yii::t('burl', 'USER_AGENT'),
            'user_refer' => Yii::t('burl', 'USER_REFER'),
            'user_ip' => Yii::t('burl', 'USER_IP'),
            'user_country' => Yii::t('burl', 'USER_COUNTRY'),
            'user_city' => Yii::t('burl', 'USER_CITY'),
            'date' => Yii::t('burl', 'DATE'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortUrl()
    {
        return $this->hasOne(ShortUrls::className(), ['id' => 'short_url_id']);
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
