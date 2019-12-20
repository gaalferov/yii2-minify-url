<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\rbac\Item;

class m170318_162158_add_new_role_and_premissions extends Migration
{
  public function safeUp()
  {

    if (!isset(Yii::$app->i18n->translations['users']) && !isset(Yii::$app->i18n->translations['users/*'])) {
      Yii::$app->i18n->translations['users'] = [
        'class' => 'yii\i18n\PhpMessageSource',
        'basePath' => '@app/messages',
        'forceTranslation' => true,
        'fileMap' => [
          'users' => 'users.php'
        ]
      ];
    }

    $this->insert('{{%auth_rule}}', [
      'name' => 'canDetails',
      'data' => 'O:20:"app\rbac\DetailsRule":3:{s:4:"name";s:10:"canDetails";s:9:"createdAt";i:1489863843;s:9:"updatedAt";i:1489863843;}',
      'created_at' => time(),
      'updated_at' => time(),
    ]);
    $this->batchInsert('{{%auth_item}}', ['name', 'type', 'description', 'rule_name', 'created_at', 'updated_at'], [
      ['user', Item::TYPE_ROLE, Yii::t('users', 'MIGRATION_USER'), NULL, time(), time()],
      ['urlCreate', Item::TYPE_PERMISSION, Yii::t('users', 'MIGRATION_URL_CREATE'), NULL, time(), time()],
      ['urlDelete', Item::TYPE_PERMISSION, Yii::t('users', 'MIGRATION_URL_DELETE'), NULL, time(), time()],
      ['urlManage', Item::TYPE_PERMISSION, Yii::t('users', 'MIGRATION_URL_MANAGE'), NULL, time(), time()],
      ['detailsView', Item::TYPE_PERMISSION, Yii::t('users', 'MIGRATION_DETAILS_VIEW'), 'canDetails', time(), time()],
    ]);

    $this->batchInsert('{{%auth_item_child}}', ['parent', 'child'], [
      ['moderator', 'urlManage'],
      ['moderator', 'user'],
      ['user', 'urlCreate'],
      ['user', 'urlDelete'],
      ['user', 'detailsView'],
    ]);

    $this->alterColumn('{{%short_urls}}', 'short_code', Schema::TYPE_STRING . '(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL');
  }

  public function safeDown()
  {
    echo "m170318_162158_add_new_role_and_premissions cannot be reverted.\n";
    return true;
  }
}
