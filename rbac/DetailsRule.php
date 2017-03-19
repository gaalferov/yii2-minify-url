<?php

namespace app\rbac;

use yii;
use yii\rbac\Rule;

class DetailsRule extends Rule
{

  public $name = 'canDetails';

  /**
   * @param int|string $user
   * @param yii\rbac\Item $item
   * @param array $params
   * @return bool
   */
  public function execute($user, $item, $params)
  {

    if (!isset($params['code'])) {
      return false;
    }

    if ($params['code']->user_id !== $user) {
      return Yii::$app->user->can('urlManage');
    }

    return true;
  }

}