<?php

namespace panix\mod\news\models;


use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;
use panix\engine\traits\query\TranslateQueryTrait;
use panix\engine\taggable\TaggableQueryBehavior;

class NewsQuery extends ActiveQuery
{

    use DefaultQueryTrait, TranslateQueryTrait;


    public function behaviors()
    {
        return [
            TaggableQueryBehavior::class,
        ];
    }
}
