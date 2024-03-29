<?php

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_136101_news
 */

use panix\engine\db\Migration;
use panix\mod\news\models\News;
use panix\mod\news\models\NewsTranslate;

class m170908_136101_news extends Migration
{

    public $text = 'Lorem ipsum dolor sit amet, consecte dunt ut labore et dot nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(News::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'category_id' => $this->integer()->unsigned(),
            'slug' => $this->string(255)->notNull(),
            'image' => $this->string()->null()->defaultValue(null),
            'views' => $this->integer()->defaultValue(0),
            'ordern' => $this->integer()->unsigned(),
            'switch' => $this->boolean()->defaultValue(true),
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
        $this->createIndex('category_id', News::tableName(), 'category_id');

        $this->createIndex('object_id', NewsTranslate::tableName(), 'object_id');
        $this->createIndex('language_id', NewsTranslate::tableName(), 'language_id');

        if ($this->db->driverName != "sqlite" || $this->db->driverName != 'pgsql') {
            $this->addForeignKey('{{%fk_news_translate}}', NewsTranslate::tableName(), 'object_id', News::tableName(), 'id', "CASCADE", "NO ACTION");
        }

        $columns = ['slug', 'user_id', 'ordern', 'created_at'];
        $this->batchInsert(News::tableName(), $columns, [
            ['about', 1, 1, time()],
            ['mypage', 1, 2, time()],
        ]);


        $columns = ['object_id', 'language_id', 'name', 'short_description', 'full_description'];
        $this->batchInsert(NewsTranslate::tableName(), $columns, [
            [1, 1, 'News 1', $this->text, $this->text],
            [2, 1, 'News 2', $this->text, $this->text],
        ]);
    }

    public function down()
    {
        if ($this->db->driverName != "sqlite" || $this->db->driverName != 'pgsql') {
            $this->dropForeignKey('{{%fk_news_translate}}', NewsTranslate::tableName());
        }
        $this->dropTable(News::tableName());
        $this->dropTable(NewsTranslate::tableName());
    }

}
