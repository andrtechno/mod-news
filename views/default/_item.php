<?php
use panix\engine\Html;

echo Html::a($model->name,$model->getUrl());
?>

<div>
    <div class="mce-content-body">
        <?= $model->isText('short_description'); ?>
    </div>
</div>
