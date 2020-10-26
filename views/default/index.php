<?php
use panix\engine\widgets\ListView;

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    //'layout' => '{sorter}{summary}{items}{pager}',
    'layout' => '{items}{pager}',
    'emptyText' => 'Empty',
    'options' => ['class' => 'list-view'],
    'itemOptions' => ['class' => 'item'],
    'emptyTextOptions' => ['class' => 'alert alert-info'],
    'pager' => [
        'class' => '\panix\engine\widgets\LinkPager',
        'options'=>['class'=>'pagination justify-content-center']
    ]
]);
?>

<?php
$tags = \panix\engine\taggable\Tag::find()->all();
?>
<?php
echo \panix\engine\taggable\TagWidget::widget([
    'items' => $tags,
    'url' => ['/news/default/index'],
    'urlParam' => 'tag',
    'format' => 'ul'
]);
?>
