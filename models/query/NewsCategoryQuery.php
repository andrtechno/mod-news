<?php

namespace panix\mod\news\models\query;

use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;
use panix\engine\traits\query\TranslateQueryTrait;

class NewsCategoryQuery extends ActiveQuery {

    use DefaultQueryTrait, TranslateQueryTrait;

    public function init()
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->addOrderBy(["{$tableName}.ordern" => SORT_DESC]);
        parent::init();
    }

}
