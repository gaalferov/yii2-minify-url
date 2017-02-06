<?php

use yii\db\Schema;
use yii\db\Migration;

class m160121_131936_short_urls extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%short_urls}}', [
            'id' => Schema::TYPE_PK,
            'long_url' => Schema::TYPE_TEXT . ' NOT NULL',
            'short_code' => Schema::TYPE_STRING . '(6) NOT NULL',
            'time_create' => Schema::TYPE_DATE . ' NOT NULL',
            'time_end' => Schema::TYPE_DATE . ' DEFAULT NULL',
            'counter' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ], $tableOptions);

        $this->createTable('{{%short_urls_info}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'short_url_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_agent' => Schema::TYPE_STRING . ' NOT NULL',
            'user_refer' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'user_ip' => Schema::TYPE_STRING . ' NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('FK_short_code', '{{%short_urls}}', 'short_code', true);
        $this->createIndex('FK_short_url_id', '{{%short_urls_info}}', 'short_url_id');
        $this->addForeignKey(
            'FK_short_url_id', '{{%short_urls_info}}', 'short_url_id', '{{%short_urls}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->batchInsert('{{%short_urls}}', ['id', 'long_url', 'short_code', 'time_create', 'time_end', 'counter'], [
            [1, 'http://gaalferov.com', 'r08wXC', '2016-01-17', '2016-01-18', 1],
            [2, 'http://gaalferov.com/about-me.html', 'D4XFhx', '2016-01-17', NULL, 0],
            [3, 'http://gaalferov.com/portfolio.html', 'SOswb1', '2016-01-18', NULL, 0],
            [4, 'http://gaalferov.com/blog.html', 'CahJk1', '2016-01-19', NULL, 0],
            [5, 'http://gaalferov.com/kontaktnaya-informaciya.html', 'toAORu', '2016-01-20', NULL, 0],
            [6, 'http://gaalferov.com/veb-programmirovanie-skripty/dorabotka-internet-magazina-natali-hair-2015.html?Itemid=0', '5PgExn', '2016-01-20', NULL, 6],
        ]);
        $this->batchInsert('{{%short_urls_info}}', ['id', 'user_id', 'short_url_id', 'user_agent', 'user_refer', 'user_ip', 'date'], [
            [1, 0, 6, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', 'http://yii2-front.loc/?page=1', '127.0.0.1', '2016-01-20'],
            [2, 0, 1, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', 'http://yii2-front.loc/?page=2', '127.0.0.1', '2016-01-18'],
            [3, 0, 6, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', 'http://yii2-front.loc/', '127.0.0.1', '2016-01-21'],
            [4, 0, 6, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', 'http://yii2-front.loc/', '127.0.0.1', '2016-01-21'],
            [5, 0, 6, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', NULL, '127.0.0.1', '2016-01-21'],
            [6, 0, 6, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:43.0) Gecko/20100101 Firefox/43.0', NULL, '127.0.0.1', '2016-01-21'],
            [7, 0, 6, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36', 'http://yii2-front.loc/index-test.php', '127.0.0.1', '2016-01-21'],
        ]);


    }

    public function down()
    {
        $this->dropTable('{{%short_urls_info}}');
        $this->dropTable('{{%short_urls}}');
    }

}
