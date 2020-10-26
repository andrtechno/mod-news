<?php

namespace panix\mod\news\models\query;

use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;
use panix\engine\traits\query\TranslateQueryTrait;

class NewsCategoryQuery extends ActiveQuery {

    use DefaultQueryTrait, TranslateQueryTrait;
}
