<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

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
 * @property NixShortUrls $shortUrl
 */
class NixUserInfo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%short_urls_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
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
}
