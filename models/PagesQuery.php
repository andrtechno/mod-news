<?php

namespace panix\mod\pages\models;

use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;

class PagesQuery extends ActiveQuery {

    use DefaultQueryTrait;
}
