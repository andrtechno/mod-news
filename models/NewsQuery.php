<?php

namespace panix\mod\news\models;

use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;

class NewsQuery extends ActiveQuery {

    use DefaultQueryTrait;
}
