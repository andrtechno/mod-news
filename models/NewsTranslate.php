<?php

namespace panix\mod\news\models;

use yii\db\ActiveRecord;

/**
 * Class NewsTranslate
 * @package panix\mod\news\models
 *
 * @property array $translationAttributes
 */
class NewsTranslate extends ActiveRecord
{

    public static $translationAttributes = ['name', 'text'];

    public static function tableName()
    {
        return '{{%news_translate}}';
    }

}
