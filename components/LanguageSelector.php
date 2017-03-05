<?php

namespace app\components;
use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{
  public $supportedLanguages = [];

  public function bootstrap($app)
  {
    $preferredLanguage = isset($app->request->cookies['language']) ? (string)$app->request->cookies['language'] : null;
    // or in case of database:
    // $preferredLanguage = $app->user->language;

    if (empty($preferredLanguage)) {
      $preferredLanguage = $app->request->getPreferredLanguage($this->supportedLanguages);
    }

    $app->language = $preferredLanguage;
  }
}