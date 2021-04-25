<?php

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170718_126334_news_categories
 */

use panix\engine\db\Migration;
use panix\mod\news\models\NewsCategory;
use panix\mod\news\models\NewsCategoryTranslate;

class m170718_126334_news_categories extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(NewsCategory::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'slug' => $this->string(255)->notNull(),
            'image' => $this->string()->null()->defaultValue(null),
            'ordern' => $this->integer()->unsigned(),
            'switch' => $this->boolean()->defaultValue(true),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null()
        ], $tableOptions);


        $this->createTable(NewsCategoryTranslate::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'object_id' => $this->integer()->unsigned(),
            'language_id' => $this->tinyInteger()->unsigned(),
            'name' => $this->string(255),
            'text' => $this->text(),
        ], $tableOptions);


        $this->createIndex('switch', NewsCategory::tableName(), 'switch');
        $this->createIndex('ordern', NewsCategory::tableName(), 'ordern');
        $this->createIndex('user_id', NewsCategory::tableName(), 'user_id');
        $this->createIndex('slug', NewsCategory::tableName(), 'slug');

        $this->createIndex('object_id', NewsCategoryTranslate::tableName(), 'object_id');
        $this->createIndex('language_id', NewsCategoryTranslate::tableName(), 'language_id');

        if ($this->db->driverName != "sqlite") {
            $this->addForeignKey('{{%fk_news_categories_translate}}', NewsCategoryTranslate::tableName(), 'object_id', NewsCategory::tableName(), 'id', "CASCADE", "NO ACTION");
        }

    }

    public function down()
    {
        if ($this->db->driverName != "sqlite") {
            $this->dropForeignKey('{{%fk_news_categories_translate}}', NewsCategoryTranslate::tableName());
        }
        $this->dropTable(NewsCategory::tableName());
        $this->dropTable(NewsCategoryTranslate::tableName());
    }

}
