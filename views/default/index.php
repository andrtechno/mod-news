<?php

echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    //'layout' => '{sorter}{summary}{items}{pager}',
    'layout' => '{items}{pager}',
    'emptyText' => 'Empty',
    'options' => ['class' => 'row list-view'],
    'itemOptions' => ['class' => 'item'],
    'emptyTextOptions' => ['class' => 'alert alert-info']
]);
?>