<?php

namespace app\components\oauth;

use budyaga\users\models\User;
use budyaga\users\models\UserOauthKey;

/**
 * Fix error with incorrect API request in initUserAttributes
 * @override budyaga\users\components\oauth\Google
 */
class Google extends \yii\authclient\clients\Google
{
    /**
     * @inheritdoc
     */
    public function getViewOptions()
    {
        return [
            'popupWidth' => 900,
            'popupHeight' => 500
        ];
    }

    public function normalizeSex()
    {
        return [
            'male' => User::SEX_MALE,
            'female' => User::SEX_FEMALE
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = implode(' ', [
                'profile',
                'email',
            ]);
        }
    }

        /**
         * @inheritdoc
         */
        protected function initUserAttributes()
        {
            $attributes = parent::initUserAttributes();

            $return_attributes = [
                'User' => [
                    'email' => $attributes['email'],
                    'username' => $attributes['name'],
                    'photo' => $attributes['picture'],
                    'sex' => 1 //empty information from Google
                ],
                'provider_user_id' => $attributes['id'],
                'provider_id' => UserOauthKey::getAvailableClients()['google'],
            ];

            return $return_attributes;
        }
}
