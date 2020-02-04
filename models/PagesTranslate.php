<?php

namespace panix\mod\pages\models;

use yii\db\ActiveRecord;

/**
 * Class PagesTranslate
 * @package panix\mod\pages\models
 *
 * @property array $translationAttributes
 */
class PagesTranslate extends ActiveRecord
{

    public static $translationAttributes = ['name', 'text'];

    public static function tableName()
    {
        return '{{%pages_translate}}';
    }

}
