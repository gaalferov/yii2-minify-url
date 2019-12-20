<?php

use yii\db\Migration;

/**
 * Class m191219_203139_short_urls_add_note_field
 */
class m191219_203139_short_urls_add_note_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%short_urls}}', 'note', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%short_urls}}', 'note');
    }
}
