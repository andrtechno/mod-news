<?php

namespace panix\mod\news\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_136101_news
 */
use Yii;
use yii\db\Migration;
use panix\mod\news\models\News;
use panix\mod\news\models\NewsTranslate;

class m170908_136101_news extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(News::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'slug' => $this->string(255)->notNull(),
            'image' => $this->string()->null()->defaultValue(null),
            'views' => $this->integer()->defaultValue(0),
            'ordern' => $this->integer()->unsigned(),
            'switch' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null()
        ], $tableOptions);


        $this->createTable(NewsTranslate::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'object_id' => $this->integer()->unsigned(),
            'language_id' => $this->tinyInteger()->unsigned(),
            'name' => $this->string(255),
            'short_description' => $this->text(),
            'full_description' => $this->text()
        ], $tableOptions);


        $this->createIndex('switch', News::tableName(), 'switch');
        $this->createIndex('ordern', News::tableName(), 'ordern');
        $this->createIndex('user_id', News::tableName(), 'user_id');
        $this->createIndex('slug', News::tableName(), 'slug');

        $this->createIndex('object_id', NewsTranslate::tableName(), 'object_id');
        $this->createIndex('language_id', NewsTranslate::tableName(), 'language_id');

        if ($this->db->driverName != "sqlite") {
            $this->addForeignKey('{{%fk_news_translate}}', NewsTranslate::tableName(), 'object_id', News::tableName(), 'id', "CASCADE", "NO ACTION");
        }

        $columns = ['slug', 'user_id', 'ordern', 'created_at'];
        $this->batchInsert(News::tableName(), $columns, [
            ['about', 1, 1, date('Y-m-d H:i:s')],
            ['mypage', 1, 2, date('Y-m-d H:i:s')],
        ]);


        $columns = ['object_id', 'language_id', 'name', 'short_description', 'full_description'];
        $this->batchInsert(NewsTranslate::tableName(), $columns, [
            [1, 1, 'О компании', '', ''],
            [2, 1, 'Тест', '', ''],
        ]);
    }

    public function down()
    {
        if ($this->db->driverName != "sqlite") {
            $this->dropForeignKey('{{%fk_news_translate}}', NewsTranslate::tableName());
        }
        $this->dropTable(News::tableName());
        $this->dropTable(NewsTranslate::tableName());
    }

}
