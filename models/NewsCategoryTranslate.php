<?php

namespace panix\mod\news\models;

use yii\db\ActiveRecord;

/**
 * Class NewsCategoryTranslate
 * @package panix\mod\news\models
 *
 * @property array $translationAttributes
 */
class NewsCategoryTranslate extends ActiveRecord
{

    public static $translationAttributes = ['name', 'text'];

    public static function tableName()
    {
        return '{{%news_categories_translate}}';
    }

}
