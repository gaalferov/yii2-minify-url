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
            [['user_agent', 'user_refer', 'user_ip'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_url_id' => 'Short Url ID',
            'user_agent' => 'User Agent',
            'user_refer' => 'User Refer',
            'user_ip' => 'User Ip',
            'date' => 'Date',
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
